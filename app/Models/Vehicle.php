<?php

    namespace App\Models;

    class Vehicle
    {
        private $available_vehicles = [
            ['type' => 'sport-car', 'speed' => 150, 'start_duration' => 0],
            ['type' => 'truck', 'speed' => 60, 'start_duration' => 0],
            ['type' => 'bike', 'speed' => 100, 'start_duration' => 0],
            ['type' => 'boat', 'speed' => 50, 'start_duration' => 0.25],
        ];

        protected $attributes = [
            'type' => null,
            'speed' => 0,
            'start_duration' => 0,
        ];

        public function __construct($type = null)
        {
            if ($type !== null) {
                $this->findByType($type);
            }
        }

        public function getAttribute($field)
        {
            return $this->attributes[$field];
        }

        public function setAttribute($field, $value)
        {
            $this->attributes[$field] = $value;
        }

        public function findByType($type)
        {
            foreach($this->available_vehicles as $vehicle) {
                if ($vehicle['type'] == $type) {
                    $this->setAttribute('type', $vehicle['type']);
                    $this->setAttribute('speed', $vehicle['speed']);
                    $this->setAttribute('start_duration', $vehicle['start_duration']);
                }
            }

            return $this->attributes;
        }

        public function isInvalid()
        {
            return $this->attributes['type'] === null;
        }

        public function getDuration($distance = 0)
        {
            if ($distance == 0) return null;

            return round($distance / $this->getAttribute('speed'), 2) + $this->getAttribute('start_duration');
        }
    }
