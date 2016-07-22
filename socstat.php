<?php
/**
 * @package Hello_Dolly
 * @version 1.6
 */
/*
Plugin Name: Soc Stat
Plugin URI: http://wordpress.org/plugins/soc-stat/
Description:
Author: Eugen Bobrowski
Version: 1.0
Author URI: http://ma.tt/
*/

class Soc_Stat_Chart
{

    protected static $instance;
    public $lib_is_load = false;
    public $current_id;

    private function __construct()
    {
        add_shortcode('chart', array($this, 'shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue'));
        add_action('wp_print_footer_scripts', array($this, 'inline_script'));
    }

    public function shortcode($atts)
    {

        $atts = wp_parse_args($atts, array(
            'w' => 19,
            'h' => 9,
            'ratio' => 1
        ));

        $this->current_id = uniqid();

        $ratio = ($atts['ratio']) ? 'ratio' : '';
        $output = '<div id="' . $this->current_id . '" class="soc-stat-chart ' . $ratio . '" '.
            'data-width="' . $atts['w'] . '" data-height="' . $atts['h'] . '" '.
            'style="width: 100%; height: 300px;"></div>';

        return $output;
    }

    public function enqueue()
    {
        wp_enqueue_script('google-charts', '//www.gstatic.com/charts/loader.js', array(), false, true);
        wp_enqueue_script('jquery');
    }

    public function inline_script()
    {
        ?>
        <script id="socstat" type="text/javascript">
            (function ($) {

                google.charts.load('current', {packages: ['corechart', 'line']});
                google.charts.setOnLoadCallback(drawBasic);

                function drawBasic() {
                    $('.soc-stat-chart').each(function () {
                        var $this = $(this);
                        var data = new google.visualization.DataTable();

                        data.addColumn('number', 'X');
                        data.addColumn('number', 'Dogs');

                        data.addRows([
                            [0, 0], [1, 10], [2, 23], [3, 17], [4, 18], [5, 9],
                            [6, 11], [7, 27], [8, 33], [9, 40], [10, 32], [11, 35],
                            [12, 30], [13, 40], [14, 42], [15, 47], [16, 44], [17, 48],
                            [18, 52], [19, 54], [20, 42], [21, 55], [22, 56], [23, 57],
                            [24, 60], [25, 50], [26, 52], [27, 51], [28, 49], [29, 53],
                            [30, 55], [31, 60], [32, 61], [33, 59], [34, 62], [35, 65],
                            [36, 62], [37, 58], [38, 55], [39, 61], [40, 64], [41, 65],
                            [42, 63], [43, 66], [44, 67], [45, 69], [46, 69], [47, 70],
                            [48, 72], [49, 68], [50, 66], [51, 65], [52, 67], [53, 70],
                            [54, 71], [55, 72], [56, 73], [57, 75], [58, 70], [59, 68],
                            [60, 64], [61, 60], [62, 65], [63, 67], [64, 68], [65, 69],
                            [66, 70], [67, 72], [68, 75], [69, 80]
                        ]);

                        var options = {
                            hAxis: {
                                title: 'Time'
                            },
                            vAxis: {
                                title: 'Popularity'
                            }
                        };

                        var chart = new google.visualization.LineChart(this);

                        chart.draw(data, options);

                    });
                }


            })(jQuery);
        </script>
        <?php
    }

    public static function get_instance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

Soc_Stat_Chart::get_instance();