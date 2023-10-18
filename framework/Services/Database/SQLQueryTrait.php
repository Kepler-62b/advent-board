<?php

namespace Framework\Services\Database;

trait SQLQueryTrait
{
    private array $inputKeywordStorage = [
        '%TABLE' => null,
        '%RANGE' => null,
        '%WHERE' => null,
        '%ORDERBY' => null,
        '%SORT' => null,
        '%LIMIT' => null,
        '%OFFSET' => null,
    ];

    private array $outputKeywordStorage = [];

    private string $selectSQL = "SELECT%RANGEFROM%TABLE%WHERE%ORDERBY%SORT%LIMIT%OFFSET";

    private function remove()
    {
        $this->selectSQL = strtr($this->selectSQL, $this->outputKeywordStorage);
    }

    public function build(): string
    {
        foreach ($this->inputKeywordStorage as $key => $value) {
            if (is_null($value)) {
                $this->selectSQL = str_replace($key, '', $this->selectSQL);
            }
        }
        return $this->selectSQL;
    }

    public function select(string $select, string $from): self
    {
        $this->inputKeywordStorage['%RANGE'] = $select;
        $this->inputKeywordStorage['%%TABLE'] = $from;

        $this->outputKeywordStorage['%RANGE'] = " $select ";
        $this->outputKeywordStorage['%TABLE'] = " $from";
        $this->remove();

        return $this;
    }

    /** @param array<string, strimg|int>|null $criteria */
    public function whereA(array $criteria = null): self
    {
        if (isset($criteria)) {
            $whereKey = $criteria['key'];
            $whereValue = $criteria['value'];
            $operator = $criteria['operator'];
            $this->outputKeywordStorage['%WHERE'] = " WHERE $whereKey $operator $whereValue";
            $this->remove();
        }

        return $this;
    }

    public function orderBy(string|int $orderBy = null): self
    {
        $this->inputKeywordStorage['%ORDERBY'] = $orderBy;

        if (isset($orderBy)) {
            $this->outputKeywordStorage['%ORDERBY'] = " ORDER BY ?";
        }
        $this->remove();

        return $this;
    }

    public function sortDirection(string $sortDirection = null): self
    {
        $this->inputKeywordStorage['%SORT'] = $sortDirection;

        if (isset($sortDirection)) {
            $this->outputKeywordStorage['%SORT'] = " $sortDirection";
        }
        $this->remove();

        return $this;
    }

    public function limit(int $limit = null): self
    {
        $this->inputKeywordStorage['%LIMIT'] = $limit;

        if (isset($limit)) {
            $this->outputKeywordStorage['%LIMIT'] = " LIMIT $limit";
        }
        $this->remove();

        return $this;
    }

    public function offset(int $offset = null): self
    {
        $this->inputKeywordStorage['%OFFSET'] = $offset;

        if (isset($offset)) {
            $this->outputKeywordStorage['%OFFSET'] = " OFFSET ?";
        }
        $this->remove();

        return $this;
    }
}
