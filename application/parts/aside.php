<?php

    function buildPackagesOptions() {
        return '';

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

    let redirectToPackage = function (package) {
        if ('' == package) {
            location.href = '<?php echo url(); ?>';
        } else {
            location.href = '<?php echo url('packages'); ?>/' + package + '.html';
        }
    };

    let redirectLanguage = function(lang) {
        let route = '<?php echo route(); ?>';
        let defaultLang = '<?php echo getLocale()::DEFAULT_LANGUAGE; ?>';
        if (route == '/' && lang != defaultLang) {
            location.href = location.href + lang;
        } else {
            location.href = location.href.replace('/<?php echo lang(); ?>/', '/' + lang + '/');
        }
    }

</script>

<aside class="right-column">
    <div class="terms">
        <p>
            Bricks Lizenz: proprietary<br>
            Kontakt: <a href="mailto:kontakt@bricks-cms.org">kontakt@bricks-cms.org</a>
        </p>
    </div>
    <nav class="locale-nav">
        <label><?php echo translate('Select your language'); ?>:</label><br />
        <select name="locale" onchange="redirectLanguage(this.value)">
            <option value="de" <?php if(lang() == 'de') echo 'selected="selected"'; ?>>Deutsch</option>
            <option value="en" <?php if(lang() == 'en') echo 'selected="selected"'; ?>>English</option>
        </select>
    </nav>
    <nav class="package">
        <label><?php echo translate('Select a package'); ?>:</label><br />
        <select name="package" onchange="redirectToPackage(this.value);">
            <option value=""><?php echo translate('Currently no documented packages'); ?> ...</option>
            <?php echo buildPackagesOptions(); ?>
        </select>
    </nav>
</aside>