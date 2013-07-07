PHPrelude
===

Why?
---

Countless of reasons:
- Why not?
- Really, why not?

Having fun
---

```php
$xs = array(
    1, 2, 3, 4, 5, 6
);

$br = '<br />';

echo head($xs) . $br;
echo sum($xs) . $br;
```

Outputs:

```
1
21
```

```php
$xs1 = array(
    array(1, 3, 5),
    array(6, 7, 10)
);

echo length(concat($xs1)) . $br;
```

Outputs:

```
6
```

```php
class Person implements Ord {
    private $sex, $age; // $sex: 0 for men 1 for ladies.
    public $name;
    public function __construct($name, $sex, $age) {
        $this->name = $name;
        $this->sex = $sex;
        $this->age = $age;
    }
    // Ladies are greater than men.
    // Older people are greater than younglings.
    public function lessOrEq($b) {
        if ($this->sex < $b->sex) {
            return true;
        }
        return $this->age <= $b->age;
    }
}

$ps = array(new Person("Joe", 0, 40),
            new Person("Eve", 1, 20),
            new Person("John", 0, 10));

echo serialize(minimum($ps));
```

Outputs:

```
O:6:"Person":3:{s:11:"Personsex";i:0;s:11:"Personage";i:10;s:4:"name";s:4:"John";}
```