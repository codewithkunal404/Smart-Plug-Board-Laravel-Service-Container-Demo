# 🧩 What is the Service Container in Laravel?

```
The Service Container is Laravel’s powerful dependency injection system.
It’s like a smart box that holds and manages all the classes your app needs — and automatically gives you the right one when you ask for it.
```


#### ⚙️ In Simple Terms

- Instead of you manually creating objects with new,
- Laravel says:

- “Just tell me what you need, and I’ll give you the correct instance.”

- Example:
```php
use App\Services\PaymentService;

class OrderController extends Controller
{
    public function __construct(PaymentService $payment)
    {
        $this->payment = $payment; // Laravel auto-injects it!
    }
}

```

- ✅ You don’t call new PaymentService() — Laravel’s container does it for you.


# ⚙️ Mini Project: Smart Plug Board — Laravel Service Container Demo
- 🎯 Concept
```
We’ll simulate devices (interfaces).

Each “wire” represents a class implementation (e.g., Fan, Light, TV).

Laravel’s Service Container will automatically inject the right wire (class) into our controller (device) — without manually creating objects.

And we’ll have a simple dropdown UI where you can switch between devices (i.e., change binding at runtime).
```

### 🧩 Folder Structure

```swift

app/
 └── Services/
      ├── PowerInterface.php
      ├── Fan.php
      ├── Light.php
      └── TV.php
app/Http/Controllers/
 └── PowerController.php
app/Providers/
 └── AppServiceProvider.php
resources/views/
 └── power.blade.php
routes/web.php

```

### ⚙️ Step 1 — Create Interface

- File: app/Services/PowerInterface.php
```php
<?php

namespace App\Services;

interface PowerInterface
{
    public function turnOn();
}
```

### 💡 Step 2 — Create Implementations

- Fan.php

```php 
<?php

namespace App\Services;

class Fan implements PowerInterface
{
    public function turnOn()
    {
        return "🌀 Fan is spinning!";
    }
}
```

- Light.php
```php
<?php

namespace App\Services;

class Light implements PowerInterface
{
    public function turnOn()
    {
        return "💡 Light is shining!";
    }
}

```

- TV.php
```php
<?php

namespace App\Services;

class TV implements PowerInterface
{
    public function turnOn()
    {
        return "📺 TV is playing your favorite show!";
    }
}
```


### ⚡ Step 3 — AppServiceProvider (Binding Logic)

- File: app/Providers/AppServiceProvider.php

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PowerInterface;
use App\Services\Fan;
use App\Services\Light;
use App\Services\TV;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind dynamically based on request query (?device=light)
        $this->app->bind(PowerInterface::class, function ($app) {
            $device = request('device', 'fan'); // default: fan

            return match ($device) {
                'light' => new Light(),
                'tv' => new TV(),
                default => new Fan(),
            };
        });
    }

    public function boot(): void
    {
        //
    }
}
```

- ✅ Now, Laravel’s Service Container decides automatically:

- Which “wire” (class) to inject into the controller — based on user input.

### 🧠 Step 4 — Create Controller

- File: app/Http/Controllers/PowerController.php

```php
<?php

namespace App\Http\Controllers;

use App\Services\PowerInterface;

class PowerController extends Controller
{
    protected $device;

    public function __construct(PowerInterface $device)
    {
        $this->device = $device;
    }

    public function show()
    {
        $message = $this->device->turnOn();
        return view('power', compact('message'));
    }
}
```
### 🌐 Step 5 — Add Route

- File: routes/web.php

```php
use App\Http\Controllers\PowerController;

Route::get('/', [PowerController::class, 'show'])->name('power');
```
### 🎨 Step 6 — Blade View

- File: resources/views/power.blade.php

```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Smart Plug Board Demo</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; }
        select, button { padding: 8px 15px; font-size: 16px; }
        .message { margin-top: 30px; font-size: 22px; font-weight: bold; }
    </style>
</head>
<body>
    <h1>⚙️ Laravel Smart Plug Board (Service Container)</h1>

    <form method="GET" action="{{ route('power') }}">
        <label for="device">Select a device:</label>
        <select name="device" id="device">
            <option value="fan" {{ request('device') == 'fan' ? 'selected' : '' }}>🌀 Fan</option>
            <option value="light" {{ request('device') == 'light' ? 'selected' : '' }}>💡 Light</option>
            <option value="tv" {{ request('device') == 'tv' ? 'selected' : '' }}>📺 TV</option>
        </select>
        <button type="submit">Turn On</button>
    </form>

    @if(isset($message))
        <div class="message">{{ $message }}</div>
    @endif
</body>
</html>
```
### 🚀 Step 7 — Run It

- Start Laravel server:
```
php artisan serve
```
```
Open browser:
👉 http://127.0.0.1:8000
```
# 🧩 Step 8 — Try It Out!

```
Browser URL → /?device=light
      ↓
Laravel resolves PowerController
      ↓
Controller asks for PowerInterface
      ↓
Container looks for a binding → finds yours
      ↓
Runs your closure:
    $device = 'light'
    → returns new Light()
      ↓
Controller receives Light object automatically
      ↓
$this->power->turnOn()
→ "💡 Light is shining!"

```


## PHP CORE 🧩 Folder Structure

```swift
container-demo/
│
├── index.php
├── Container.php
├── PowerInterface.php
├── Fan.php
├── Light.php
├── TV.php
└── PowerController.php
```
### 📄 1️⃣ PowerInterface.php
```php
<?php

interface PowerInterface {
    public function turnOn();
}
```
### 📄 2️⃣ Fan.php
```php
<?php

require_once 'PowerInterface.php';

class Fan implements PowerInterface {
    public function turnOn() {
        echo "🌀 Fan is spinning!<br>";
    }
}
```

### 📄 3️⃣ Light.php
```php
<?php

require_once 'PowerInterface.php';

class Light implements PowerInterface {
    public function turnOn() {
        echo "💡 Light is shining!<br>";
    }
}
```

### 📄 4️⃣ TV.php
```php
<?php

require_once 'PowerInterface.php';

class TV implements PowerInterface {
    public function turnOn() {
        echo "📺 TV is playing!<br>";
    }
}
```

### 📄 5️⃣ Container.php

```php
<?php

class Container {
    protected array $bindings = [];

    // Register a binding (like app()->bind())
    public function bind($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    // Resolve (like app()->make())
    public function make($abstract)
    {
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract]($this);
        }

        throw new Exception("Nothing bound for {$abstract}");
    }
}
```

### 📄 6️⃣ PowerController.php
```php
<?php

require_once 'PowerInterface.php';

class PowerController {
    protected PowerInterface $power;

    public function __construct(PowerInterface $power)
    {
        $this->power = $power;
    }

    public function start()
    {
        $this->power->turnOn();
    }
}
```
### 📄 7️⃣ index.php
```php
<?php

require_once 'Container.php';
require_once 'Fan.php';
require_once 'Light.php';
require_once 'TV.php';
require_once 'PowerController.php';

// Create the container instance
$container = new Container();

// Register a binding (like Laravel's $this->app->bind)
$container->bind(PowerInterface::class, function($app) {
    $device = $_GET['device'] ?? 'fan'; // default to fan

    return match ($device) {
        'tv' => new TV(),
        'light' => new Light(),
        default => new Fan(),
    };
});

// Resolve dependency (simulate Laravel’s automatic injection)
$power = $container->make(PowerInterface::class);
$controller = new PowerController($power);

// Execute method
$controller->start();

```
### 🧠 How to Run
```
Save all files in a folder named container-demo.

Open terminal inside that folder.

Run:

php -S localhost:8000


Open browser and test:

🔹 http://localhost:8000 → 🌀 Fan is spinning!

🔹 http://localhost:8000?device=light → 💡 Light is shining!

🔹 http://localhost:8000?device=tv → 📺 TV is playing!
```