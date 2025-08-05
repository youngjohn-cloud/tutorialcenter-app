<?php
/* Section is use to replace class. 
* we can't have Class as a name of Object 
* due to php inbuilt keyword
* so we decided to use section
*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'department',
    ];
}
