<?php

    function buildPackagesOptions() {

        $curPackage = dirname(str_replace(
            [directory(), 'pages/packages/'],
            '',
            realpath($_SERVER['SCRIPT_FILENAME'])
        ));

        $html = '';
        $optgroups = glob(directory('pages/packages') . '/*');

        usort($optgroups, function($a, $b){
            $a = basename($a);
            $b = basename($b);
            if ($a == 'bricks-cms') return -1;
            if ($a == 'bricks-framework') return 1;
            if ($a == 'bricks-cmf' && $b == 'bricks-cms') return 1;
            if ($a == 'bricks-cmf' && $b == 'bricks-framework') return -1;
        });

        foreach ($optgroups as $path) {
            $optgroupItem = basename($path);
            $options = glob($path . '/*');
            $html .= '<optgroup label="' . $optgroupItem . '">';
            foreach ($options as $path) {
                $option = basename($path);
                $html .= '<option value="' . $optgroupItem . '/' . $option . '"';
                if ($optgroupItem . '/' . $option == $curPackage) {
                    $html .= ' selected="selected" ';
                }
                $html .= '>' . $optgroupItem . '/' . $option . '</option>';
            }
            $html .= '</optgroup>';
        }
        return $html;
    }

?>

<script type="text/javascript">
    let redirectToPackage = function (optionValue) {
        if ('' == optionValue) {
            location.href = '<?php echo url(); ?>';
        } else {
            location.href = '<?php echo url('pages/packages'); ?>/' + optionValue + '/index.php';
        }
    };
</script>

<aside class="right-column">
    <nav class="package">
        <label><?php echo lang('Select a package'); ?>:</label><br />
        <select name="package" onchange="redirectToPackage(this.value);">
            <option value=""><?php echo lang('Please select a package'); ?> ...</option>
            <?php echo buildPackagesOptions(); ?>
        </select>
    </nav>
    <nav class="locale-nav">
        <label><?php echo lang('Select your language'); ?>:</label><br />
        <select name="locale" onchange="Page.setLocale(this.value);">
            <option value="de" <?php if($locale == 'de') echo 'selected="selected"'; ?>>Deutsch</option>
            <option value="en" <?php if($locale == 'en') echo 'selected="selected"'; ?>>English</option>
        </select>
    </nav>
</aside>