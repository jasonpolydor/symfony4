<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2019/06/26
 * Time: 14:06
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension implements GlobalsInterface
{

    /**
     * @var string
     */
    private $locale;
    /**
     * @var string
     */
    private $service_message;

    public function __construct(string $locale, string $service_message)
    {

        $this->locale = $locale;
        $this->service_message = $service_message;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('price',[$this, 'priceFilter'])
        ];
    }

    public function getGlobals()
    {
       return [
           'locale' => $this->locale,
           'service_message' => $this->service_message
       ];
    }

    public function priceFilter($number){
        return '$' . number_format($number, 2, '.', ',');
    }
}
