<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Banner\Test\Constraint;

use Magento\Banner\Test\Fixture\Banner;
use Magento\Banner\Test\Page\Adminhtml\BannerIndex;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertBannerInGrid
 * Assert that created banner is found by name and has correct banner types, visibility, status
 */
class AssertBannerInGrid extends AbstractConstraint
{
    /* tags */
    const SEVERITY = 'low';
    /* end tags */

    /**
     * Assert that created banner is found by name and has correct banner types, visibility, status
     *
     * @param Banner $banner
     * @param BannerIndex $bannerIndex
     * @return void
     */
    public function processAssert(Banner $banner, BannerIndex $bannerIndex)
    {
        $bannerIndex->open();
        $filter = [
            'banner' => $banner->getName(),
            'active' => $banner->getIsEnabled(),
        ];

        $bannerIndex->getGrid()->search($filter);
        if ($banner->hasData('types')) {
            $types = implode(', ', $banner->getTypes());
            $filter['types'] = $types;
        }

        \PHPUnit\Framework\Assert::assertTrue(
            $bannerIndex->getGrid()->isRowVisible($filter, false),
            'Dynamic Block is absent in dynamic block grid.'
        );
    }

    /**
     * Text present Banner in the Banner grid
     *
     * @return string
     */
    public function toString()
    {
        return 'Dynamic Block in grid.';
    }
}
