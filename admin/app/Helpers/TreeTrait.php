<?php
namespace App\Helpers;

use Illuminate\Support\Collection;

trait TreeTrait {


    /**
     * $this->>hasChildren
     * Check if it has direct childrens
     *
     * @return bool
     */
    public function getHasChildrenAttribute()
    {
        $left = $this->lft;
        $right = $this->rgt;

        if(is_null($left) || is_null($right)) return false;

        return $right - $left > 1;
    }


    /**
     * $this->children
     * Returns direct childrens
     *
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('lft');
    }

    /**
     * $this->descendants
     * Returns the collection of all descendants
     *
     * @return Collection
     */
    public function getDescendantsAttribute()
    {
        return self::where([
            ['lft', '>', $this->lft],
            ['rgt', '<', $this->rgt]
        ])->orderBy('lft')->get();
    }


    /**
     * $this->hasParent
     * Returns bool whether this has its own parent
     *
     * @return bool
     */
    public function getHasParentAttribute()
    {
        return !is_null($this->parent_id);
    }


    /**
     * $this->parent
     * Returns direct parent
     *
     * @return mixed
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * $this->>ascendants
     * Returns the collection of all ascendants in the order of the highest
     *
     * @return Collection
     */
    public function getAscendantsAttribute()
    {
        $current = $this;
        $ascendants = collect();

        while($current->hasParent){
            $current = $current->parent;
            $ascendants->push($current);
        }

        return $ascendants->reverse();
    }


    /**
     * $this->toplevel()
     * get top level scope
     *
     * @param $query
     * @return mixed
     */
    public function scopeToplevel($query)
    {
        return $query->where('depth', 1)->orWhere('depth', null)->orWhere('depth', 9)->orderBy('lft');
    }



    // return multi array tree list
    public static function tree()
    {
        $items = self::orderBy('lft')->get();

        $flatItems = [];
        foreach($items as $item){
            $flatItems[$item->id] = [
                'item' => $item,
                'depth' => $item->depth,
                'children' => []
            ];
        }

        $nested = [];
        $depths = [];
        $count = 0;

        foreach($flatItems as $key => $item){

            // if depth is undefined or 0 or 1 = highest lvl
            if(is_null($item['depth']) || !$item['depth'] || $item['depth'] == 1){
                $nested[$key] = $item;
                $depths[(int)$item['depth'] + 1] = $key;
            }

            // for others
            else {
                $parent =& $nested;
                for($i=2; $i<=$item['depth']; $i++){
                    $parent =& $parent[$depths[$i]]['children'];
                }

                $parent[$key] = $item;
                $depths[(int)$item['depth'] + 1] = $key;
            }

            $count++;
        }

        return $nested;
    }




    public function printChildren($callback, &$out=null)
    {
        if($this->hasChildren){
            $callback($this, function() use ($callback, &$out){
                foreach($this->children as $child){
                    $child->printChildren($callback, $out);
                }


            }, $out);
        }
        else {
            $callback($this, false, $out);
        }
    }


    /**
     * Return HTML of the tree : li(s) after root ul
     * @param $branchTemplate
     * @return string
     * @internal param $template
     */
    public static function treeHtml($branchTemplate)
    {
        ob_start();

        foreach(self::toplevel()->get() as $topitem){

            $topitem->printChildren(function($item, $children) use ($branchTemplate){
                echo view($branchTemplate, compact('item', 'children'));
            });
        }

        $html = ob_get_contents();
        ob_end_clean();


        return $html;

        /*
         * Example of the blade template
         *
            <li>
                <span>{{ $item->title }}</span>

                @if($children)
                <ul>
                    @php $children(); @endphp
                </ul>
                @endif
            </li>
        */

    }




    /**
     * Returns built-HTML string,
     * Do this on your controller
     * @return string
     */
    public static function treeExample()
    {
        $html = '<ul>';

        foreach(self::toplevel()->get() as $topitem){


            $topitem->printChildren( function($item, $children, &$html){

                $html .= '<li>';
                $html .= $item->title;
                if($children){ // children exist
                    $html .= '<ul>';
                    $children();
                    $html .= '</ul>';
                }
                $html .= '</li>';

            }, $html);
        }

        $html.='</ul>';

        return $html;
    }

    /**
     * Echo out on the fly
     * Do this on your view
     */
    public static function treeExampleTwo()
    {
        foreach(self::toplevel()->get() as $topitem){

            $topitem->printChildren( function($item, $children){
                echo '<li>';
                echo $item->title;
                if($children){
                    echo '<ul>';
                    $children();
                    echo '</ul>';
                }
                echo '</li>';
            });
        }
    }









}