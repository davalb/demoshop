<?php

/**
 * This file is part of the Spryker Demoshop.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Collector;

use Pyz\Zed\Collector\Persistence\Search\Pdo\PostgreSql\ProductCollectorQuery as SearchProductCollector;
use Pyz\Zed\Collector\Persistence\Storage\Pdo\PostgreSql\CategoryNodeCollectorQuery;
use Pyz\Zed\Collector\Persistence\Storage\Pdo\PostgreSql\NavigationCollectorQuery;
use Pyz\Zed\Collector\Persistence\Storage\Pdo\PostgreSql\ProductCollectorQuery;
use Pyz\Zed\Collector\Persistence\Storage\Pdo\PostgreSql\UrlCollectorQuery;
use Spryker\Zed\Collector\CollectorConfig as SprykerCollectorConfig;

class CollectorConfig extends SprykerCollectorConfig
{

    /**
     * @return array
     */
    public function getStoragePdoQueryAdapterClassNames($dbEngineName)
    {
        $data = [
            'MySql' => [

            ],
            'PostgreSql' => [
                'CategoryNodeCollectorQuery' => CategoryNodeCollectorQuery::class,
                'NavigationCollectorQuery' => NavigationCollectorQuery::class,
                'ProductCollectorQuery' => ProductCollectorQuery::class,
                'UrlCollectorQuery' => UrlCollectorQuery::class,
            ]
        ];

        return $data[$dbEngineName];
    }

    /**
     * @return array
     */
    public function getSearchPdoQueryAdapterClassNames($dbEngineName)
    {
        $data = [
            'MySql' => [

            ],
            'PostgreSql' => [
                'ProductCollectorQuery' => SearchProductCollector::class,
            ]
        ];

        return $data[$dbEngineName];
    }

    /**
     * @return int
     */
    public function getNumberOfShards()
    {
        return 1;
    }

    /**
     * @return int
     */
    public function getNumberOfReplicas()
    {
        return 1;
    }

}
