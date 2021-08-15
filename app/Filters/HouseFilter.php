<?php

namespace App\Filters;

class HouseFilter extends QueryFilter
{
    public function type_propertyId($id = null){
        return $this->builder->when($id, function($query) use($id){
            $query->where('type_propertyId', $id);
        });
    }

    public function typeId($id = null){
        return $this->builder->when($id, function($query) use($id){
            $query->where('typeId', $id);
        });
    }

    public function countryId($id = null){
        return $this->builder->when($id, function($query) use($id){
            $query->where('countryId', $id);
        });
    }

    public function cityId($id = null){
        return $this->builder->when($id, function($query) use($id){
            $query->where('cityId', $id);
        });
    }

    public function rooms($count = null){
        return $this->builder->when($count, function($query) use($count){
            $query->where('rooms', $count);
        });
    }

    public function floors($count = null){
        return $this->builder->when($count, function($query) use($count){
            $query->where('floors', $count);
        });
    }

    public function areaFrom($area = null){
        return $this->builder->when($area, function($query) use($area){
            $query->where('area', '>=', $area);
        });
    }

    public function areaTo($area = null){
        return $this->builder->when($area, function($query) use($area){
            $query->where('area', '<=', $area);
        });
    }

    public function priceFrom($price = null){
        return $this->builder->when($price, function($query) use($price){
            $query->where('price', '>=', $price);
        });
    }

    public function priceTo($price = null){
        return $this->builder->when($price, function($query) use($price){
            $query->where('price', '<=', $price);
        });
    }
}
