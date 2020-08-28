<?php

namespace Queue;

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * @package     Queue
 * @copyright   2020 Podvirnyy Nikita (Observer KRypt0n_)
 * @license     GNU GPL-3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @author      Podvirnyy Nikita (Observer KRypt0n_)
 * 
 * Contacts:
 *
 * Email: <suimin.tu.mu.ga.mi@gmail.com>
 * VK:    <https://vk.com/technomindlp>
 *        <https://vk.com/hphp_convertation>
 * 
 */

/**
 * Структура данных "очередь"
 */
class Queue
{
    /**
     * @var array $items - массив элементов
     * @var int $begin   - указатель на начало очереди
     * @var int $end     - указатель на конец очереди
     */
    protected array $items  = [];
    protected int $begin = 0;
    protected int $end   = 0;

    /**
     * Конструктор очереди
     * 
     * [@param array $items = []] - список элементов, добавляемых в очередь
     */
    public function __construct (array $items = [])
    {
        $this->items = array_values ($items);
        $this->end   = sizeof ($items);
    }

    /**
     * Добавление элемента в конец очереди
     * 
     * @param mixed $item - элемент для добавления в конец очереди
     * 
     * @return Queue
     */
    public function push ($item): Queue
    {
        $this->items[$this->end++] = $item;

        return $this;
    }

    /**
     * Получение элемента из начала очереди
     * 
     * @throws Exception - выбрасывает исключение если очередь пуста
     * 
     * @return mixed
     */
    public function pop ()
    {
        if (!isset ($this->items[$this->begin]))
            throw new \Exception ('Queue is empty');
        
        $item = $this->items[$this->begin];

        unset ($this->items[$this->begin++]);

        return $item;
    }

    /**
     * Получение числа элементов в очереди
     * 
     * @return int
     */
    public function count (): int
    {
        return $this->end - $this->begin;
    }

    /**
     * Проход по всем элементам очереди от начала до конца
     * 
     * @param callable $callback - коллбэк function(mixed $item)
     * 
     * @return Queue
     */
    public function foreach (callable $callback): Queue
    {
        for ($i = $this->begin; $i < $this->end; ++$i)
            $callback ($this->items[$i]);

        return $this;
    }

    /**
     * Фильтр элементов очереди с помощью коллбэка
     * 
     * @param callable $comparator - коллбэк function(mixed $item): bool
     * 
     * @return array - возвращает список отфильтрованных элементов
     */
    public function where (callable $comparator): array
    {
        $return = [];

        for ($i = $this->begin; $i < $this->end; ++$i)
            if ($comparator ($this->items[$i]))
                $return[] = $this->items[$i];

        return $return;
    }

    /**
     * Получение списка элементов в очереди от первого к последнему
     * 
     * @return array
     */
    public function list (): array
    {
        $list = [];

        for ($i = $this->begin; $i < $this->end; ++$i)
            $list[] = $this->items[$i];

        return $list;
    }

    /**
     * Удаление всех элементов очереди
     * 
     * @return Queue
     */
    public function clear (): Queue
    {
        $this->items = [];
        $this->begin = 0;
        $this->end   = 0;

        return $this;
    }
}
