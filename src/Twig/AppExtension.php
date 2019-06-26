<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2019/06/26
 * Time: 14:06
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('price',[$this, 'priceFilter'])
        ];
    }

    public function priceFilter($number){
        return '$' . number_format($number, 2, '.', ',');
    }
}
