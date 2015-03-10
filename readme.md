# Thumbsnag

Thumbsnag crawls a webpage and makes a best effort at finding imagery that represents the given page.

### Example

```php
use Thumbsnag\Thumbsnag;

$images = Thumbsnag::inspect('http://simplegifts.co');
```

After inspection, `$images` might return:

```bash
  array(4) {
    [0]=>
    string(21) "http://simplegifts.co/"
  }
```

### Credits

### License

Thumbsnag is open-sourced software licensed under the [MIT license](https://raw.githubusercontent.com/gstjohn/Thumbsnag/master/LICENSE)