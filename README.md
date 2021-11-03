![realblocks logo](https://www.realblocks.com/hs-fs/hubfs/RealBlocks%20-%20black%20logo.png?width=144&name=RealBlocks%20-%20black%20logo.png)

# RealBlocks Interview Challenge

## Solution

### PART I: Building a request + write md file to engineer to extend a builder as a task

A good approach would be to use the builder design pattern to construct the request object based on the given data.
However, we need to keep in mind that the request object can have nested objects, so we need to think to solve this in
a *recursive* fashion.

#### The implementation of the builder design pattern starts as follows:

Namings & Definitions:

* Payload: The request *data* on which to be built based on the *input* & api structure requirements.
* Request: The request *object* including the url.

Assumptions:

* The input data is an object of type User.

Added directories & files:

* App\Builders\Payloads\AbstractPayloadBuilder.php (Recursive logic).
* App\Builders\Payloads\FinancialAid\{Basic,Entity,Foreign}.php (concrete implementations, an engineer would create
  something like those based on a future task).
* App\Builders\Requests\FinancialAid\AbstractRequestBuilder.php (This one looks simple because all we need to do is pass
  a concrete implementation of this ['data', 'api_url'] to the Http Facade or any guzzle package to talk to the
  third-party api)
* App\Builders\Requests\FinancialAid\FinancialAidRequestBuilder.php (concrete implementation).
* App\Builders\Payloads\Example.php
* App\Builders\Requests\Example.php
* App\config\external_apis.php

Usage:

1. Identify which third-part api we are sending to, including the request structure (target data).
2. Use the concrete implementation of the request builder that corresponds to that api, otherwise create it extending
   the abstract request builder.

Here's a concrete Implementation of the Request Builder:

```php
namespace App\Builders\Requests\FinancialAid;

use App\Builders\Payloads\FinancialAid\Basic;
use App\Builders\Requests\AbstractRequestBuilder;

class FinancialAidRequestBuilder extends AbstractRequestBuilder
{
    public function getURL()
    {
        return config('external_apis.financial_aid');
    }

    public function build()
    {
        $basic = new Basic($this->input);

        return $basic->build();
    }
}
```

3. Use the concrete implementation of the payload builders that corresponds to that api, otherwise create them extending
   the abstract payload builder.

This piece of data must be a default inside the payload:

```php
namespace App\Builders\Payloads\FinancialAid;

use App\Builders\Payloads\AbstractPayloadBuilder;

// Due to the Third-Party API Requirements, this class must always be included.
class Basic extends AbstractPayloadBuilder
{
    public $additions = [Entity::class, Foreign::class];

    public function getName()
    {
        return 'basic';
    }

    public function transform()
    {
        return [
            "name" => $this->input->name,
            "email" => $this->input->email,
            "national_number" => $this->input->national_number,
            "phone" => $this->input->phone,
        ];
    }
}
```

However, this one has rules:

```php
namespace App\Builders\Payloads\FinancialAid;

use App\Builders\Payloads\AbstractPayloadBuilder;

class Foreign extends AbstractPayloadBuilder
{
    public function getName()
    {
        return 'foreign';
    }

    public function transform()
    {
        return [
            "country" => "jordan",
        ];
    }

    public function rules()
    {
        return [
            'is_foreign' => 'required|in:1'
        ];
    }

    public function prepare()
    {
        $this->input->is_foreign = (string)$this->input->is_foreign;
    }
}
```

4.

### PART II: Approach Multi-tenancy

Disclaimer: I mainly learned how to do this from a youtube
video [[Live-Coding] Laravel Multi-Tenancy with Single Trait](https://www.youtube.com/watch?v=nCiNqboYFVQ)

#### Approach:

The transaction model includes the value, user_id & the company To make it generic, we will use a trait (
Multitenantable) where it holds a global scope getting the transaction based on the user_id which created it.

#### Strategies:

* Adding a static global scope and a creating model event inside each boot method for the desired models
* Refactoring and extracting these to an observer for each model then register them inside the app service provider.
* Or ultimately just create and use a trait that holds the global scope and events.

#### Trade-offs:

1. More code needs to be written, but code growth is minimized by using traits.
2. If we are moving from a single tenant database to a multitenantable one, tables will be altered to add a new column
   that represents the transaction creator id.

#### Thank you!
