# api-responder

> Fast build php web api response. Support laravel/lumen framework. Not support hyperf.

### install

`composer require qeezer/api-responder ^1.0`

---

### usage

#### use QeeZer\ApiResponder\ResponderFactory

```php
<?php

namespace App\Controllers;

use QeeZer\ApiResponder\ResponderFactory;
use Request;
use App\Models\User;

class IndexController
{
    public function index(Request $request)
    {
        return ResponderFactory::responseSuccess();
    }
    
    public function item(Request $request)
    {
        return ResponderFactory::responseItem(User::find(1));
    }
    
    public function collection(Request $request)
    {
        return ResponderFactory::responseCollection(User::all());
    }
    
    public function paginate(Request $request)
    {
        return ResponderFactory::responsePaginate(User::simplePaginate(10));
    }
    
    public function data(Request $request)
    {
        return ResponderFactory::responseData([
            'is_can' => true,
            'name' => 'Tom',
        ]);
    }
    
    public function collection(Request $request)
    {
        if (!$request->user()) {
            return ResponderFactory::responseUnauthorized();
        }
        
        return ResponderFactory::responseItem($request->user());
    }
}
```

#### use QeeZer\ApiResponder\Responder

app/Controllers/BaseController.php

```php
<?php

namespace App\Controllers;

use QeeZer\ApiResponder\Responder;
use Request;

class BaseController
{
    use Responder;
}
```

app/Controllers/IndexController.php

```php
<?php

namespace App\Controllers;

use QeeZer\ApiResponder\Responder;
use Request;

class IndexController extends BaseController
{
    public function index(Request $request)
    {
        return $this->responseSuccess();
    }
}
```

#### use response resource

app/Resources/UserResource.php

```php
<?php

namespace App\Resources;

use QeeZer\ApiResponder\DefaultResource;

class UserResource extends DefaultResource
{
    public function toArray(): array
    {
        return [
            'id' => $this->data['id'],
            'name' => $this->data['name'],
            'phone' => $this->data['mobile'],
        ];
    }
}

```

app/Controllers/UserController.php

```php
<?php

namespace App\Controllers;

use App\Models\User;
use App\Resources\UserResource;
use QeeZer\ApiResponder\Responder;
use Request;

class IndexController extends BaseController
{
    public function detail(Request $request)
    {
        $data = $this->validata([
            'uid' => 'required|int'
        ], $request->all());
        
        return $this->responseItem(User::find($data['uid']), UserResource::class);
    }
}
```

---

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

---

### in laravel or lumen

app/Exceptions/Handler.php
```php
public function render($request, $exception)
{
    // other
    
    return \QeeZer\ApiResponder\Helpers::laravelExceptionRender($request, $exception);
}
```