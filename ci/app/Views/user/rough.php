
        $pr_id = $pr_db_data['id'];
        $pr_d_lines = json_decode($pr_db_data['d_lines'],true);
        $pr_upgrade_wallet = $pr_db_data['upgrade_wallet'];
        $pr_p_wallet = $pr_db_data['p_wallet'];
        $pr_c_wallet = $pr_db_data['c_wallet'];

        $fname = $pr_db_data['f_name'];

        if (!isset($pr_d_lines['L3'])) {
            echo (' In P2i, Parent Referrer '.$fname.' L3 Null');

            $d_lines_lists1 = [];
            foreach ($pr_d_lines['L1'] as $key => $value) {
                $d_lines_lists1[$key] = $value;
            };
            $d_lines_lists2 = [];
            foreach ($pr_d_lines['L2'] as $key => $value) {
                $d_lines_lists2[$key] = $value;
            };

            $downlines = [
                'L1' => $d_lines_lists1,
                'L2' => $d_lines_lists2,
                'L3' => [$n_id],
            ];
            $downlines = json_encode($downlines);
            $data = [
                'upgrade_wallet' => $pr_upgrade_wallet + 12500, //increase referrer upgrade wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($pr_id, $data);
        }elseif (count($pr_d_lines['L3']) == 1) {
            echo (' In P2i, Parent Referrer L3 Second');

            $d_lines_lists1 = [];
            foreach ($pr_d_lines['L1'] as $key => $value) {
                $d_lines_lists1[$key] = $value;
            };
            $d_lines_lists2 = [];
            foreach ($pr_d_lines['L2'] as $key => $value) {
                $d_lines_lists2[$key] = $value;
            };
            $d_lines_lists3 = [];
            foreach ($pr_d_lines['L3'] as $key => $value) {
                $d_lines_lists3[$key] = $value;
            };
            $d_lines_lists3[count($d_lines_lists3)] = $n_id;

            $downlines = [
                'L1' => $d_lines_lists1,
                'L2' => $d_lines_lists2,
                'L3' => $d_lines_lists3,
            ];
            $downlines = json_encode($downlines);
            $data = [
                'upgrade_wallet' => $pr_upgrade_wallet + 12500, //increase referrer pending wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($pr_id, $data);
            $this->upwallet($pr_id);
        }else {
            echo (' In P2i, Parent Referrer L3 Others');
            $d_lines_lists1 = [];
            foreach ($pr_d_lines['L1'] as $key => $value) {
                $d_lines_lists1[$key] = $value;
            };
            $d_lines_lists2 = [];
            foreach ($pr_d_lines['L2'] as $key => $value) {
                $d_lines_lists2[$key] = $value;
            };
            $d_lines_lists3 = [];
            foreach ($pr_d_lines['L3'] as $key => $value) {
                $d_lines_lists3[$key] = $value;
            };
            $d_lines_lists3[count($d_lines_lists3)] = $n_id;

            $downlines = [
                'L1' => $d_lines_lists1,
                'L2' => $d_lines_lists2,
                'L3' => $d_lines_lists3,
            ];
            $downlines = json_encode($downlines);
            $data = [
                'p_wallet' => $pr_p_wallet + 8750, //increase product wallet 
                'c_wallet' => $pr_c_wallet + 3750, //increase product wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($pr_id, $data);
        }

        _____________________________________Ended___________________________________

        <?php foreach ($orders  as $key => $order): ?>
                        <?php if($order['status'] == 'Pending'):  ?>
                            <div class="card-body border-top order">
                                <?php foreach (json_decode($order['orders']) as $key => $ord):?>
                                <div class="media mt-2">
                                    <figure class="icons icon-40 mr-2 bg-light-warning">
                                        <i class="material-icons">query_builder</i>
                                    </figure>
                                    <div class="media-body">
                                        <h6 class="mb-1"><?=$ord->name?> <span class="text-danger">x<?=$ord->count?></span> </h6>
                                        <p class="mb-0 text-mute small">&#x20a6;<?=price($ord->total)?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php elseif ($order['status'] == 'Cancelled'): ?>
                            <div class="card-body border-top order">
                                <?php foreach (json_decode($order['orders']) as $key => $ord):?>
                                <div class="media mt-2">
                                    <figure class="icons icon-40 mr-2 bg-light-danger">
                                        <i class="material-icons">cancel</i>
                                    </figure>
                                    <div class="media-body">
                                        <h6 class="mb-1"><?=$ord->name?> <span class="text-danger">x<?=$ord->count?></span> </h6>
                                        <p class="mb-0 text-mute small">&#x20a6;<?=price($ord->total)?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php elseif ($order['status'] == 'Completed'): ?>
                            <div class="card-body border-top order">
                                <?php foreach (json_decode($order['orders']) as $key => $ord):?>
                                <div class="media mt-2">
                                    <figure class="icons icon-40 mr-2 bg-light-success">
                                        <i class="material-icons">check</i>
                                    </figure>
                                    <div class="media-body">
                                        <h6 class="mb-1"><?=$ord->name?> <span class="text-danger">x<?=$ord->count?></span> </h6>
                                        <p class="mb-0 text-mute small">&#x20a6;<?=price($ord->total)?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif;endforeach; ?>