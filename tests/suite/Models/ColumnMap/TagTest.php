<?php
/**
 * CsvImportPlus_ColumnMap_TagTest class
 *
 * @copyright Copyright 2007-2012 Roy Rosenzweig Center for History and New Media
 * @license http://www.gnu.org/licenses/gpl-3.0.txt GNU GPLv3
 * @package CsvImportPlus
 */
class CsvImportPlus_ColumnMap_TagTest extends CsvImportPlus_Test_AppTestCase
{
    public function testConstructWithoutTagDelimiter()
    {
        $columnName = 'title';
        $map = new CsvImportPlus_ColumnMap_Tag($columnName);
        $this->assertInstanceOf('CsvImportPlus_ColumnMap_Tag', $map);
        $this->assertEquals(CsvImportPlus_ColumnMap::TYPE_TAG, $map->getType());
    }

    public function testConstructWithTagDelimiter()
    {
        $columnName = 'title';
        $tagDelimiter = ',';
        
        $map = new CsvImportPlus_ColumnMap_Tag($columnName, $tagDelimiter);
        $this->assertInstanceOf('CsvImportPlus_ColumnMap_Tag', $map);
        $this->assertEquals(CsvImportPlus_ColumnMap::TYPE_TAG, $map->getType());
        $this->assertEquals($tagDelimiter, $map->getTagDelimiter());
    }

    public function testMapWithoutTagDelimiter()
    {
        $columnName = 'title';
        $tagDelimiter = ',';
        $this->assertEquals($tagDelimiter, CsvImportPlus_ColumnMap_Tag::getDefaultTagDelimiter());
        
        $beforeTagArray = array('a','B','c', ' d', ' E', ' f ', ' G ', 'h ', 'I ', ' j K ');
        $afterTagArray = array('a','B','c', 'd', 'E', 'f', 'G', 'h', 'I', 'j K');
        $tagString = implode($tagDelimiter, $beforeTagArray);
        
        $row = array($columnName => $tagString);
        
        $map = new CsvImportPlus_ColumnMap_Tag($columnName);
        $this->assertInstanceOf('CsvImportPlus_ColumnMap_Tag', $map);
        $this->assertEquals($afterTagArray, $map->map($row, array()));
    }
    
    public function testMapWithTagDelimiter()
    {
        $columnName = 'title';
        $defaultTagDelimiter = ',';
        $this->assertEquals($defaultTagDelimiter, CsvImportPlus_ColumnMap_Tag::getDefaultTagDelimiter());
        
        $tagDelimiter = '|';
        $beforeTagArray = array('a','B','c', ' d', ' E', ' f ', ' G ', 'h ', 'I ', ' j K ');
        $afterTagArray = array('a','B','c', 'd', 'E', 'f', 'G', 'h', 'I', 'j K');
        $tagString = implode($tagDelimiter, $beforeTagArray);
        
        $row = array($columnName => $tagString);
        
        $map = new CsvImportPlus_ColumnMap_Tag($columnName, $tagDelimiter);
        $this->assertInstanceOf('CsvImportPlus_ColumnMap_Tag', $map);
        $this->assertEquals($afterTagArray, $map->map($row, array()));
    }
}