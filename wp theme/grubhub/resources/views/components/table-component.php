<?php

/**
 * Table Component Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

require_once('helper-functions.php');
$field_or_subfield = isset($is_flex) ? 'get_sub_field' : 'get_field';

// Load values and assign defaults.
$headline = call_user_func($field_or_subfield, 'headline');
$col1 = call_user_func($field_or_subfield, 'first_column');
$columns = call_user_func($field_or_subfield, 'body_columns');
$bottom = call_user_func($field_or_subfield, 'bottom_heading');
$padding = call_user_func($field_or_subfield, 'custom_padding');
?>
<script type="text/javascript" src="/wp-content/themes/GrubHub/resources/assets/scripts/table.js?v1.0.2"></script>

<section class="table-component" style="<?php echo $padding['padding_top'] != '' ? "padding-top: " . $padding['padding_top'] . 'px; ' : ''; echo $padding['padding_bottom'] != '' ? "padding-bottom: " . $padding['padding_bottom']. "px" : ''; ?>">
    <div class="row heading align-<?php echo $headline['alignment']; ?>">
        <?php if (!empty($headline['headline'])): ?>
            <h2 class="<?php echo $headline['color']; ?>"><?php echo $headline['headline']; ?></h2>
        <?php endif; ?>
    </div>
    <div class="row align-middle">
    <table class="hover striped show-for-large">
        <caption class="sr-only"><?php echo $headline['headline']; ?></caption>
        <thead>
        <tr class="recommended_row">
            <td></td>
            <?php
            $cols = $columns['column_labels'];
            if ($cols) {
                foreach ($cols as $key => $col) {
                    $is_highlighted = $col['highlighted'];
                    echo $is_highlighted ? '<td class="recommended">Recommended</td>' : '<td>&nbsp;</td>';
                }
            }
            ?>
        </tr>
        <tr>
            <th width="420"><p class="subhead"><?php echo $col1['column_heading']; ?></p></th>
            <?php
            $cols = $columns['column_labels'];
            if ($cols) {
                foreach ($cols as $col) {
                    echo '<th width="210" scope="col" class="col"><p class="head3">' . $col['column_description_heading'] . '</p></th>';
                }
            }
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
            $rows = $col1['row_items'];
            if ($rows) {
                $tbody = '';
                foreach ($rows as $row) {
                    $text_check = $row['column_content'];
                    $is_text = $text_check['text_or_check'];
                    $check_cols = implode(',', $text_check['check_on_columns']);

                    // Check if the data is text and not checkmark.
                    if ($is_text == 'text') {
                        $text = explode(',', $text_check['text']);
                    }

                    // Build initial rows description.
                    $tr = '<tr>';
                    $tr .= "<td width='420' scope='row'>" . $row['description'] . "</td>\r\n";

                    // Populate the rest of the columns and show content if
                    // text or checkmark based on the column configuration.
                    $cols = $columns['column_labels'];
                    if ($cols) {
                        foreach ($cols as $key => $col) {
                            // Since array starts at 0, and our column reference in
                            // fieldgroups is col2/3/4, then we need to start the key
                            // at +2, that way, we will get a match.
                            $col_key = 'col' . ($key + 2);
                            $is_highlighted = $col['highlighted'];
                            $recommended = $is_highlighted ? ' class="recommended"' : '';

                            // Two ternary operation happening. One checks if text, prints it
                            // otherwise, it then checks if this column has been ticked in
                            // the config, then it would show checkmark, otherwise, just blank.
                            $tdata = (($is_text == 'text') ? trim($text[$key]) :
                                ((strpos($check_cols, $col_key) > -1) ? '<i class="fas fa-check"></i>' : ''));
                            $tr .= "<td$recommended>$tdata</td>\r\n";
                        }
                    }

                    $tr .= '</tr>';
                    $tbody .= $tr;
                }
                echo $tbody;
            }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <p class="head3 align-<?php echo $bottom['subtext']['alignment'] . ' ' . $bottom['subtext']['color']; ?>">
                        <?php echo $bottom['subtext']['subheading']; ?>
                    </p>
                </td>
                <?php
                $ctas = $bottom['cta'];
                if ($ctas) {
                    foreach ($ctas as $cta) {
                        $new_cta = [
                          'style' => $cta['style'],
                          'url' => $cta['link']['url'],
                          'text' => $cta['link']['title'],
                        ];
                        echo "<td>" . print_cta($new_cta) . "</td>";
                    }
                }
                ?>
            </tr>
        </tfoot>
    </table>

    <div class="row hide-for-large tabs-content-wrap">
        <div class="columns">
            <ul class="tabs" data-tabs id="table-to-tab-component">
                <?php
                if ($cols) {
                    foreach ($cols as $key => $col) {
                        $name = 'panel' . $key;
                        $is_active = $key == 0 ? ' is-active' : '';
                        echo "<li class='tabs-title$is_active'><a data-tabs-target='$name' href='#$name'>".$col['column_description_heading']."</a></li>";
                    }
                }
                ?>
            </ul>
            <div class="tabs-content" data-tabs-content="table-to-tab-component">
                <?php
                if ($cols) {
                    foreach ($cols as $key => $col) {
                        $name = 'panel' . $key;
                        $is_active = $key == 0 ? ' is-active' : '';
                        $html = '<div class="tabs-panel'.$is_active.'" id="'.$name.'">';
                        $html .= '<table class="hover striped ' . $name . '"><tbody></tbody>';

                        // Build Tfooter.
                        $cta = $bottom['cta'][$key];
                        $new_cta = [
                            'style' => $cta['style'],
                            'url' => $cta['link']['url'],
                            'text' => $cta['link']['title'],
                        ];
                        $tfoot = '<tfoot><tr><td>';
                        $tfoot .= '<p class="subfoot align-' . $bottom['subtext']['alignment'] . ' ' . $bottom['subtext']['color'] . '">';
                        $tfoot .= $bottom['subtext']['subheading'] . '</p></td>';

                        $tfoot .= '<td>' . print_cta($new_cta) . '</td>';
                        $tfoot .= '</tr></tfoot>';
                
                
                        $html .= $tfoot . '</table></div>';
                        print $html;
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>