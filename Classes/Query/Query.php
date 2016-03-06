<?php

namespace Query;

class Query
{
    /**
     * ビューID(旧名: Profile ID)
     *
     * @var string
     */
    private $view_id = "";

    /**
     * 集計開始日
     *
     * @var \DateTime
     */
    private $start_date = null;

    /**
     * 集計終了日
     *
     * @var \DateTime
     */
    private $end_date = null;

    /**
     * 指標グループ
     *
     * @var array
     */
    private $metrics = [];

    /**
     * ディメンション
     *
     * @var \Dimensions\Dimensions
     */
    private $dimensions = null;

    /**
     * 結果のソートの指定
     *
     * @var string
     */
    private $sort = null;

    /**
     * フィルター
     * 集計結果のうちフィルターに適合するものだけが返される(たぶん)
     *
     * @var \Filters\Filters
     */
    private $filter = null;

    /**
     * セグメント
     * データのうちセグメントに適合するものだけが集計される(たぶん)
     *
     * @var \Segment\Segment
     */
    private $segment = null;


    public function __construct()
    {
    }
}
