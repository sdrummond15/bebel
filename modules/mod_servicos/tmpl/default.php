<div class="modservicos">
    <div class="servicos">

        <?php
        echo '<h1>' . $titulo . '</h1>';
        $count = 0;
        foreach ($servicos as $servicos) {


            if ($count < 5) {

                echo '<div class="servico">';



                $db = &JFactory::getDBO();
                $query = $db->getQuery(true);
                $query->select('*');
                $query->from('#__menu');
                $query->where('link = "index.php?option=com_content&view=article&id=' . $servicos->id . '" AND published=1');
                $db->setQuery($query);
                $menu = $db->loadObjectList();

                if (!empty($menu)) {
                    $link = 'index.php/' . $menu[0]->path;
                } else {
                    $link = 'index.php?option=com_content&view=article&id=' . $servicos->id;
                }

                echo '<a href="' . $link . '" >';
                $image = (json_decode($servicos->images));
                echo '<figure class="servimg"><img src="' . $image->image_intro . '" alt="' . $servicos->alias . '"/></figure>';
                echo '<figcaption><p>' . $servicos->title . '</p></figcaption>';
                echo '</a>';

                echo '</div>';

                $count++;
            }
        }
        ?>
    </div>
</div>