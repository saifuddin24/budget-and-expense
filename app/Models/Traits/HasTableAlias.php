<?php
namespace App\Models\Traits;

trait HasTableAlias {
    protected $alias;

    public static function tableAs( $alias )
    {
        $model = (new static);
 
        $model->alias = $alias;
        $model->setTable( $model->getTable() . ' as '. $alias);

        return $model->newQuery();
    }

    /**
     * Qualify the given column name by the model's table.
     *
     * @param  string  $column
     * @return string
     */
    public function qualifyColumn($column)
    {
        if( $this->alias ) {
            return $this->alias.'.'.$column;
        }
        
        return parent::qualifyColumn($column);
    }

}