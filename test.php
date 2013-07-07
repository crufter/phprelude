<?php

require("phprelude.php");

class PHPreludeTest extends PHPUnit_Framework_TestCase {
    // Misc functions
    public function testId() {
        $this->assertEquals(1, id(1));
    }
    
    public function testCon() {
        $this->assertEquals(1, con(1, 2));
    }
    
    public function testDot() {
        $double = function($a) {
            return $a*2;
        };
        $minusTen = function($a) {
            return $a-10;
        };
        $comb = dot($minusTen, $double);
        $this->assertEquals(50, $comb(30));
    }
    
    public function testFlip() {
        $flipped = flip(function($a, $b) {
            return $a-$b;
        });
        $this->assertEquals(7, $flipped(3, 10));
    }
    
    // List operations.
    public function testMap() {
        $add1 = function($a) {
            return $a+1;
        };
        $this->assertEquals(array(1,2,3), map($add1, array(0,1,2)));
    }
    
    public function testPp() {
        $this->assertEquals(array(4,10,12), pp(array(), array(4,10,12)));
        $this->assertEquals(array(4,10,12), pp(array(4), array(10,12)));
        $this->assertEquals(array(4,10,12), pp(array(4,10,12), array()));
    }
    
    public function testFilter() {
        $isEven = function($a) {
            return $a%2==0;
        };
        $this->assertEquals(array(10, 12),  filter($isEven, array(5,10,12)));
        $this->assertEquals(array(),        filter($isEven, array()));
    }
    
    public function testHead() {
        $this->assertEquals(10, head(array(10, 12)));
    }
    public function testLast() {
        $this->assertEquals(12, last(array(10, 12)));
    }
    
    public function testTail() {
        $this->assertEquals(array(12, 20),  tail(array(10, 12, 20)));
        $this->assertEquals(array(),        tail(array(20)));
    }
    
    public function testInit() {
        $this->assertEquals(array(),        init(array(10)));
        $this->assertEquals(array(10),      init(array(10, 12)));
        $this->assertEquals(array(10,20),   init(array(10, 20, 30)));
    }
    public function testNul() {
        $this->assertEquals(true, nul(array()));
        $this->assertEquals(false, nul(array(1)));
    }
    
    public function testLength() {
        $this->assertEquals(0, length(array()));
        $this->assertEquals(2, length(array(5, 10)));
    }
    
    public function testReverse() {
        $this->assertEquals(array(3,2,1), reverse(array(1,2,3)));
        $this->assertEquals(array(), reverse(array()));
    }
    
    // Reducing lists
    public function testFoldl() {
        $add = function($a, $b) {
            return $a+$b;
        };
        $sub = function($a, $b) {
            return $a-$b;
        };
        $this->assertEquals(foldl($add, 0, array(1,2,3)), $add($add($add(0, 1), 2), 3));
        $this->assertEquals(-1, foldl($sub, 0, array(1)));
    }
    
    public function testFold1() {
        $prod = function($a, $b) {
            return $a*$b;
        };
        $this->assertEquals(6, foldl1($prod, array(2,3)));
    }
    
    public function testFoldr() {
        $sub = function($a, $b) {
            return $a-$b;
        };
        $this->assertEquals(99, foldr($sub, 100, array(1)));
    }
    
    // This is actually such a bad test, same as testFoldl etc...
    // TODO: Fix it later.
    public function testFoldr1() {
        $sub = function($a, $b) {
            return $a-$b;
        };
        $this->assertEquals(99, foldr($sub, 100, array(1)));
    }
    
    public function testAnd() {
        $this->assertEquals(true,   _and(array()));
        $this->assertEquals(true,   _and(array(true, true, true)));
        $this->assertEquals(false,  _and(array(true, false, true)));
    }
    
    public function testOr() {
        $this->assertEquals(false,  _or(array()));
        $this->assertEquals(true,   _or(array(false, true, false)));
        $this->assertEquals(false,  _or(array(false, false)));
    }
    
   // More tests to come...
}

?>