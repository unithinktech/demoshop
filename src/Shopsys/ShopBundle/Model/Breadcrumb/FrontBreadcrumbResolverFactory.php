<?php

namespace Shopsys\ShopBundle\Model\Breadcrumb;

use Shopsys\ShopBundle\Component\Breadcrumb\BreadcrumbResolver;
use Shopsys\ShopBundle\Model\Article\ArticleBreadcrumbGenerator;
use Shopsys\ShopBundle\Model\Breadcrumb\FrontBreadcrumbGenerator;
use Shopsys\ShopBundle\Model\Category\CategoryBreadcrumbGenerator;
use Shopsys\ShopBundle\Model\Product\Brand\BrandBreadcrumbGenerator;
use Shopsys\ShopBundle\Model\Product\ProductBreadcrumbGenerator;

class FrontBreadcrumbResolverFactory
{
    /**
     * @var \Shopsys\ShopBundle\Model\Breadcrumb\FrontBreadcrumbGenerator[]
     */
    private $breadcrumbGenerators;

    public function __construct(
        ArticleBreadcrumbGenerator $articleBreadcrumbGenerator,
        CategoryBreadcrumbGenerator $categoryBreadcrumbGenerator,
        ProductBreadcrumbGenerator $productBreadcrumbGenerator,
        FrontBreadcrumbGenerator $frontBreadcrumbGenerator,
        BrandBreadcrumbGenerator $brandBreadcrumbGenerator
    ) {
        $this->breadcrumbGenerators = [
            $articleBreadcrumbGenerator,
            $categoryBreadcrumbGenerator,
            $productBreadcrumbGenerator,
            $frontBreadcrumbGenerator,
            $brandBreadcrumbGenerator,
        ];
    }

    /**
     * @return \Shopsys\ShopBundle\Component\Breadcrumb\BreadcrumbResolver
     */
    public function create()
    {
        $frontBreadcrumbResolver = new BreadcrumbResolver();
        foreach ($this->breadcrumbGenerators as $breadcrumbGenerator) {
            foreach ($breadcrumbGenerator->getRouteNames() as $routeName) {
                $frontBreadcrumbResolver->registerGenerator($routeName, $breadcrumbGenerator);
            }
        }

        return $frontBreadcrumbResolver;
    }
}
