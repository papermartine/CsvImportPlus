<?php
/**
 *
 */
class CsvImport_ImportTask extends Omeka_JobAbstract
{
    private $_importId;
    private $_method = 'start';
    private $_memoryLimit;

    public function perform()
    {
        if ($this->_memoryLimit) {
            ini_set('memory_limit', $this->_memoryLimit);
        }
        if ($import = $this->_getImport()) {
            call_user_func(array($import, $this->_method));
        }    
        if ($import->isPaused()) {
            $this->_dispatcher->send(__CLASS__, 
                array(
                    'importId' => $import->id, 
                    'memoryLimit' => $this->_memoryLimit,
                    'method' => 'resume'
                )
            );
        }
    }

    public function setMemoryLimit($limit)
    {
        $this->_memoryLimit = $limit;
    }

    public function setImportId($id)
    {
        $this->_importId = $id;
    }

    public function setMethod($name)
    {
        $this->_method = $name;
    }

    private function _getImport()
    {
        return $this->_db->getTable('CsvImport_Import')->find($this->_importId);
    }
}
