<?php

namespace Isotope\Test\Widget;

use Isotope\Widget\NumberField;

class NumberFieldTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $objWidget = new NumberField(array('name'=>'test_number_field'));
        $this->assertInstanceOf('Isotope\Widget\NumberField', $objWidget);
    }

    /**
     * @dataProvider inputProvider
     */
    public function testInput($input, $output, $exception=null)
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }

        \Input::setPost('test_number_field', $input);
        $objWidget = new NumberField(array('name'=>'test_number_field', 'value'=>$input));
        $objWidget->validate();

        $this->assertEquals($output, $objWidget->value);
    }

    public function inputProvider()
    {
        return array(
            array('15.00', 150000),
            array('0', 0),
            array('150', 1500000),
            array('-1', -10000),
            array('foobar.00', 0, 'InvalidArgumentException'),
            array('test', 0, 'InvalidArgumentException'),
        );
    }
}