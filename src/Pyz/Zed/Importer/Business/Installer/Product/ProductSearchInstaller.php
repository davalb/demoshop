<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Importer\Business\Installer\Product;

use Orm\Zed\Product\Persistence\SpyProductQuery;
use Propel\Runtime\Formatter\ArrayFormatter;
use Pyz\Zed\Importer\Business\Installer\AbstractInstaller;
use Spryker\Shared\Library\BatchIterator\PropelBatchIterator;

class ProductSearchInstaller extends AbstractInstaller
{

    /**
     * @return \Spryker\Shared\Library\BatchIterator\CountableIteratorInterface
     */
    protected function buildBatchIterator()
    {
        $query = SpyProductQuery::create();
        $query->setFormatter(new ArrayFormatter());
        return new PropelBatchIterator($query, 100);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Product Search';
    }

}
