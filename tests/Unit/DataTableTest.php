<?php

/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);
/*
 * Symfony DataTables Bundle
 * (c) Omines Internetbureau B.V. - https://omines.nl/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Unit;

use Omines\DataTablesBundle\Column\Column;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\DataTablesBundle;
use Omines\DataTablesBundle\DataTableState;
use PHPUnit\Framework\TestCase;

/**
 * DataTableTest.
 *
 * @author Niels Keurentjes <niels.keurentjes@omines.com>
 */
class DataTableTest extends TestCase
{
    public function testBundle()
    {
        $bundle = new DataTablesBundle();
        $this->assertSame('DataTablesBundle', $bundle->getName());
    }

    public function testFactory()
    {
        $factory = new DataTableFactory(['className' => 'foo'], ['dom' => 'bar']);

        $table = $factory->create(['name' => 'bar'], ['pageLength' => 684]);
        $this->assertSame('bar', $table->getSetting('name'));
        $this->assertSame('foo', $table->getSetting('className'));
        $this->assertSame('bar', $table->getOption('dom'));
        $this->assertSame(684, $table->getOption('pageLength'));

        $table = $factory->create(['className' => 'bar'], ['dom' => 'foo']);
        $this->assertSame('bar', $table->getSetting('className'));
        $this->assertSame('foo', $table->getOption('dom'));
        $this->assertNull($table->getSetting('none'));
        $this->assertNull($table->getOption('invalid'));
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function testInvalidSetting()
    {
        new DataTable(['setting' => 'foo'], []);
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException
     */
    public function testInvalidOption()
    {
        new DataTable([], ['option' => 'bar']);
    }

    public function testDataTableState()
    {
        $state = new DataTableState();

        // Test sane defaults
        $this->assertSame(0, $state->getStart());
        $this->assertSame(-1, $state->getLength());
        $this->assertSame(0, $state->getDraw());
        $this->assertSame('', $state->getSearch());
        $this->assertEmpty($state->getColumns());

        $state->setStart(5);
        $state->setLength(10);
        $state->setSearch('foo');
        $state->addColumn(new Column());

        $this->assertSame(5, $state->getStart());
        $this->assertSame(10, $state->getLength());
        $this->assertSame('foo', $state->getSearch());
        $this->assertInstanceOf(Column::class, $state->getColumn(0));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDataTableStateInvalidColumn()
    {
        (new DataTableState())->getColumn(5);
    }
}
