<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug'];

    protected $allowIncluded = ['posts', 'posts.user']; //si no defines es porque el modelo no tendra relaciones
    protected $allowFilter = ['id', 'name', 'slug'];
    protected $allowSort = ['id', 'name', 'slug'];


    public function scopeIncluded(Builder $query)
    {

        if (empty($this->allowIncluded) || empty(request('included'))) {
            return;
        }

        $relations = explode(',', request('included')); //['posts','relacion2']
        $allowIncluded = collect($this->allowIncluded);

        foreach ($relations as $key => $relationship) {
            if (!$allowIncluded->contains($relationship)) {
                unset($relations[$key]);
            }
        }

        $query->with($relations);
    }



    public function scopeFilter(Builder $query)
    {
        if (empty($this->allowFilter) || empty(request('filter'))) {
            return; //si no hay retorna
        }

        $filters = request('filter'); //filter ya es un array
        $allowFilter = collect($this->allowFilter); //convertimos allowfilter en coleccion

        foreach ($filters as $filter => $value) { // filter tienen por ejemplo name y value rep
            if ($allowFilter->contains($filter)) {
                $query->where($filter, 'LIKE', '%' . $value . '%');
            }
        }
    }


    public function scopeSort(Builder $query)
    {
        if (empty($this->allowSort) || empty(request('sort'))) {
            return;
        }

        $sortFields = explode(',', request('sort'));//capturamos los valores y lo ponemos en un array
        $allowSort = collect($this->allowSort);//la lista blanca lo ponemos en colleccion

        foreach ($sortFields as $sortField) {

            $direction = 'asc';//por defecto asc

            if (substr($sortField, 0, 1) == '-') {
                $direction = 'desc';
                $sortField = substr($sortField, 1);//sortfield toma nuevo valor si era -id  sera id
            }

            if ($allowSort->contains($sortField)) {
                $query->orderBy($sortField, $direction);
            }
        }
    }


    public function scopeGetOrPaginate(Builder $query){
        if (request('perPage')) {
            $perPage = intval(request('perPage'));

            if ($perPage) {
                return $query->paginate($perPage);//por ser el ultimo scope poner return
            }
        }

        return $query->get();//por ser el ultimo scope poner return
    }




    //Relacion uno a muchos
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
