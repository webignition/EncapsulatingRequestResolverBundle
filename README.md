# Encapsulating Request Resolver Bundle

Easily inject your own request-encapsulating objects into controller actions.

Tired of injecting the current request into your controller action and then having to poke around in `$request->query` or `$request->request` for relevant data?

Ever found yourself wanting to model an inbound request in a more domain-specific manner by encapsulating the current request and calling domain-specific methods to get information about the request?

This helps you do that.

## Platform requirements

 - PHP `>=8.0.2`
 - Symfony `5.4.* || 6.0.*`

## Installation

### Add as a composer dependency

```bash
composer require webignition/encapsulating-request-resolver-bundle
```

### Register bundle (if not using Symfony Flex)

```php
# config/bundles.php
return [
    //...
    webignition\EncapsulatingRequestResolverBundle\EncapsulatingRequestResolverBundle::class => ['all' => true],
];

```

## Usage

Any object implementing [`EncapsulatingRequestInterface`](https://github.com/webignition/EncapsulatingRequestResolverBundle/blob/main/Model/EncapsulatingRequestInterface.php) can be injected as a controller action argument.

`EncapsulatingRequestInterface` has a single static `create()` method into which is passed the current request. You can do whatever you like with the request.

## Example User Creation Scenario

### Scenario

Consider an API endpoint for creating a user of an application. The endpoint expects a `POST` request having a payload with `email` and `password` fields. A controller will be ultimately responsible for accessing the relevant aspects of the request and making that information available to relevant services.

### Without using this bundle

We can inject the current request into the controller action and poke around in the request payload.

```php
# src/Controller/UserController
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController 
{
    public function create(Request $request): Response
    {
        $email = (string) $request->request->get('email');
        $password = (string) $request->request->get('password');

        // ... pass $email and $password to relevant services, build and return a response
    }
}
```
This is a very simplified example. In practice we may want to be checking that both `$email` and `$password` are not empty. 

For more complex requests, validation of the request data prior to processing may be required. It is easy to start to get into territory where request-accessing logic is beyond the responsibilities of the controller.

Even with the more simple of examples, the controller needs to be aware of the shape of the request payload. It could be argued that even this small amount of information is beyond the responsibilities of the controller.

### Using this bundle

We can create a custom request class for handling and understanding the data present in a request to create a user. The logic for processing the Symfony request is encapsulated with the custom request class. The custom request class is injected into the controller action.

The more complex or involved your request processing logic is, the more it may make sense to keep that logic under the responsibility of its own class.

```php
# src/Request/CreateUserRequest.php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use webignition\EncapsulatingRequestResolverBundle\Model\EncapsulatingRequestInterface;

class CreateUserRequest implements EncapsulatingRequestInterface
{
    public function __construct(private string $email, private string $password)
    {
    }

    public static function create(Request $request): CreateUserRequest
    {
        return new CreateUserRequest(
            (string) $request->request->get('email'),
            (string) $request->request->get('password')
        );
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
```

```php
# src/Controller/UserController
namespace App\Controller;

use App\Request\CreateUserRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController 
{
    public function create(CreateUserRequest $request): Response
    {     
        $email = $request->getEmail();
        $password = $request->getPassword());

        // ... pass $email and $password to relevant services, build and return a response      
    }
}
```

