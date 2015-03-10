# Thumbsnag

Thumbsnag crawls a webpage and makes a best effort at finding imagery that represents the given page.

### Example

```php
use Thumbsnag\Thumbsnag;
use DOMDocument;

$html = file_get_contents('http://simplegifts.co');
$document = DOMDocument::loadHTML($html);
$thumbsnag = Thumbsnag::load($document);
$images = $thumbsnag->process();
```

After inspection, `$images` might return:

```bash
array(2) {
  [0]=>
  string(31) "http://simplegifts./image1.jpg"
  [1]=>
  string(31) "http://simplegifts./image1.jpg"
}
```

### Credits

### License

Thumbsnag is open-sourced software licensed under the [MIT license](https://raw.githubusercontent.com/gstjohn/Thumbsnag/master/LICENSE)