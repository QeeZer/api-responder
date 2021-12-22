# api-responder

`composer require qeezer/api-responder`

### usage

#### use QeeZer\ApiResponder\ResponderFactory

```php
<?php

namespace App\Controllers;

use QeeZer\ApiResponder\ResponderFactory;
use Request;

class IndexController
{
    public function index(Request $request)
    {
        return ResponderFactory::responseSuccess();
    }
}
```

#### use QeeZer\ApiResponder\Responder

```php
<?php

namespace App\Controllers;

use QeeZer\ApiResponder\Responder;
use Request;

class IndexController
{
    use Responder;
    public function index(Request $request)
    {
        return $this->responseSuccess();
    }
}
```

### response list

```php
ResponderFactory::responseItem();
ResponderFactory::responseCollection();
ResponderFactory::responsePaginate();
ResponderFactory::responseData();
ResponderFactory::responseSuccess();
ResponderFactory::responseFail();
ResponderFactory::responseError();
ResponderFactory::responseUnauthorized();
ResponderFactory::responseCreated();
```

### in laravel or lumen

app/Exceptions/Handler.php
```php
public function render($request, $exception)
{
    // other
    
    return \QeeZer\ApiResponder\Helpers::laravelExceptionRender($request, $exception);
}
```