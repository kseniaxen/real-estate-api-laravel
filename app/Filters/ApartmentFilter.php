<?php

namespace App\Filters;

class ApartmentFilter extends QueryFilter
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

    public function currencyId($id = null){
        return $this->builder->when($id, function($query) use($id){
            $query->where('currencyId', $id);
        });
    }

    public function rooms($count = null){
        if($count >= 4){
            return $this->builder->when($count, function($query) use($count){
                $query->where('rooms','>=', $count);
            });
        }else{
            return $this->builder->when($count, function($query) use($count){
                $query->where('rooms', $count);
            });
        }
    }

    public function floorFrom($count = null){
        return $this->builder->when($count, function($query) use($count){
            $query->where('floor', '>=', $count);
        });
    }

    public function floorTo($count = null){
        return $this->builder->when($count, function($query) use($count){
            $query->where('floor', '<=', $count);
        });
    }

    public function floorsFrom($count = null){
        return $this->builder->when($count, function($query) use($count){
            $query->where('floors', '>=', $count);
        });
    }

    public function floorsTo($count = null){
        return $this->builder->when($count, function($query) use($count){
            $query->where('floors', '<=', $count);
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
