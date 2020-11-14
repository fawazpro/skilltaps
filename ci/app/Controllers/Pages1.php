<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public $SHARED = 18000;
    public $SHAREDL1 = 50;
    public $SHAREDL2 = 2000;
    public $SHAREDL3 = 4000;
    public $SHAREDL4 = 1250;
    public $SHAREDL5 = 1250;
    public function index()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $session = session();
            $id = $session->id;
            $users = new \App\Models\Customers();
            $db_data = $users->where('user_id', $id)->find()[0];
            
            echo view('user/header');
            // echo view('user/home');
            echo view('user/home', $db_data);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function login()
    {
        echo view('user/authheader');
        echo view('user/login');
    }

    public function register()
    {
        echo view('user/authheader');
        echo view('user/register');
    }

    public function makePayment($id)
    {
        echo view('user/authheader');
        echo view('user/payment', ['id' => $id]);
    }

    public function postregister()
    {
        $users = new \App\Models\Customers();
        $incoming = $this->request->getPost();
        $ref_id = $incoming['ref'];
        $user_id = 'SH'.substr(uniqid(), -5) ;
        $ref_confirm = $users->where('user_id', $ref_id)->find();

        if (!empty($ref_confirm)) {
            $data = [
                'user_id' => $user_id,
                'fname' => $incoming['fname'],
                'lname' => $incoming['lname'],
                'email' => $incoming['email'],
                'phone' => $incoming['phone'],
                'sex' => $incoming['sex'],
                'address' => $incoming['address'],
                'paid' => 0,
                'ref_id' => $ref_id,
                'password' => hash('sha1', $incoming['pass'], false),
                'ref1' => $ref_id,
                'ref2' => $ref_confirm[0]['ref1'],
                'ref3' => $ref_confirm[0]['ref2'],
                'ref4' => $ref_confirm[0]['ref3'],
                'ref5' => $ref_confirm[0]['ref4'],
            ];

            if (null !== ($users->insert($data))) {
                $this->makePayment($user_id);
            } else {
                echo 'Not Successful';
            }
        } else {
            echo 'Invalid Referrer ID';
        }
    }

    public function postlogin()
    {
        $users = new \App\Models\Customers();
        $incoming = $this->request->getPost();
        $data = [
            'email' => $incoming['email'],
            'password' => hash('sha1', $incoming['pass'], false),
        ];
        $result = $users->where($data)->find();
        if ($result) {
            if ($result[0]['paid']) {
                $ses_data = [
                    'id' => $result[0]['user_id'],
                    'f_name' => $result[0]['fname'],
                    'email' => $result[0]['email'],
                    'paid' => $result[0]['paid'],
                    'logged_in' => TRUE,
                ];
                $session = session();
                $session->set($ses_data);
                $this->index();
            } else {
                $this->makePayment($result[0]['user_id']);
            }
        } else {
            echo 'Login not Successful';
        }
    }


    // public function processpay()
    // {
    //     $users = new \App\Models\Users();
    //     $incoming = $this->request->getGet();
    //     $user_id = substr(uniqid('SH'), -5) ;
    //     $data = [
    //         'paid' => 1,
    //         'user_id' => $user_id
    //     ];
        
    //     $id = $incoming['sku'];
    //     $users->update($id, $data);
    //     echo ('Handing over to P1');
    //     $this->pivotal1($id);
    //     $this->index();
    // }
    public function redir()
    {
        echo view('user/authheader');
        echo view('user/redirect');
    }

    public function processpay()
    {
        $users = new \App\Models\Customers();
        $incoming = $this->request->getGet();
        $data = [
            'paid' => 1,
        ];
        
        $id = $incoming['sku'];
        $users->update($id, $data);
        echo ('Handing over to credit');
        $this->credit($id);
        $this->redir();
    }

    private function credit($id){
        $users = new \App\Models\Customers();
        $p_db_data = $users->where('user_id', $id)->find()[0];
        $ref1 = $p_db_data['ref1'];
        $ref2 = $p_db_data['ref2'] ? $p_db_data['ref2'] : 'alpha';
        $ref3 = $p_db_data['ref3'] ? $p_db_data['ref3'] : 'alpha';
        $ref4 = $p_db_data['ref4'] ? $p_db_data['ref4'] : 'alpha';
        $ref5 = $p_db_data['ref5'] ? $p_db_data['ref5'] : 'alpha';
        
        $this->addtowallet($ref1, $this->SHAREDL1);
        $this->addtowallet($ref2, $this->SHAREDL2);
        $this->addtowallet($ref3, $this->SHAREDL3);
        $this->addtowallet($ref4, $this->SHAREDL4);
        $this->addtowallet($ref5, $this->SHAREDL5);
        return;
    }

    private function addtowallet($id, $amt){
        $users = new \App\Models\Customers();
        $db_data = $users->where('user_id', $id)->find()[0];
        $wallet = $db_data['wallet'] + $amt;
        $users->update($id, ['wallet' => $wallet]);
        return;
    }

    private function pivotal1(int $id)
    {
        /*
        $r_db_data :: Referrer data
        $p_db_data :: Personal data
        */
        $users = new \App\Models\Users();
        $p_db_data = $users->where('id', $id)->find()[0];

        $ref_id = $p_db_data['ref_id'];
        $r_db_data = $users->where('user_id', $ref_id)->find()[0];

        $d_lines = json_decode($r_db_data['d_lines'],true);

        $r_id = $r_db_data['id'];

        $up_wallet = $r_db_data['upgrade_wallet'];

        $p_wallet = $r_db_data['p_wallet'];
        $c_wallet = $r_db_data['c_wallet'];

        // Actions
        if ($p_db_data['level'] < 1) {
            $users->update($id, ['level' => 1]);
        }
        
        $fname =  $r_db_data['f_name'];
        echo(' Referrer is equal to'.$fname);
        if ($d_lines == NULL) {
            $downlines = [
                'L1' => [$id],
            ];
            $downlines = json_encode($downlines);
            $data = [
                'upgrade_wallet' => $up_wallet + 12500, //increase referrer upgrade wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($r_id, $data);
        } elseif (count($d_lines['L1']) == 1) {
            $downlines = [
                'L1' => [$d_lines['L1'][0], $id],
            ];
            $downlines = json_encode($downlines);
            $data = [
                'upgrade_wallet' => $up_wallet + 12500, //increase referrer upgrade wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($r_id, $data);
            $upgraded = $this->upwallet($r_id); //Upgrade on the second person
            if($upgraded){
                $this->checkReferrerLevel($p_db_data['ref_id'], $id ,1);
            }
        } else {
            $downlines = [];
            $d_lineKeys = array_keys($d_lines);
            var_dump($d_lineKeys);
            for ($i=0; $i < count($d_lineKeys); $i++) {
                $g = $d_lineKeys[$i]; 
                foreach ($d_lines[$g] as $key => $value) {
                    $downlines[$d_lineKeys[$i]][$key] = $value;
                };
            }
            $tmp = [];
            $tmp['L1'] = $downlines['L1'];
            $numb = count($tmp['L1']);
            $tmp['L1'][$numb] = $id;

            $result = array_merge($downlines, $tmp);
            $downlines = json_encode($result);
            $data = [
                'p_wallet' => $p_wallet + 7000, //increase referrer product wallet 
                'c_wallet' => $c_wallet + 3000, //increase referrer product wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($r_id, $data);
            $upgraded = $this->upwallet($r_id); //Upgrade on the second person
            if($upgraded){
                $this->checkReferrerLevel($p_db_data['ref_id'], $id ,1);
            }
        }
        
        // $this->checkReferrerLevel($p_db_data['ref_id'], $id);
    }

    private function checkReferrerLevel($id, $n_id ,$flag)
    {
        /*
        Referrer ID Passed
        */
        $users = new \App\Models\Users();

        if(($r_db_data = $users->where('user_id', $id)->find()) == null){
            $r_db_data = NULL;
        }else{
            $r_db_data = $r_db_data[0];            
        }

        if(($pr_db_data = $users->where('user_id', $r_db_data['ref_id'])->find()) == null){
            $pr_db_data = NULL;
        }else{
            $pr_db_data = $pr_db_data[0];            
        }

        if(($gpr_db_data = $users->where('user_id', $pr_db_data['ref_id'])->find()) == null){
            $gpr_db_data = NULL;
        }else{
            $gpr_db_data = $gpr_db_data[0];            
        }


        if($flag == 1 && $r_db_data != null && $pr_db_data != null && $gpr_db_data != null){
            echo ('In CRL LEvel 3');
            $this->pivotal2ii($n_id, $r_db_data, $pr_db_data, $gpr_db_data);
        }elseif ($flag == 1 && $r_db_data != null && $pr_db_data != null) {
            echo ('In CRL LEvel 2');

            $this->pivotal2i($n_id, $r_db_data, $pr_db_data);
        }
        elseif ($r_db_data != null) {
            echo ('In CRL LEvel 3');
            return true;
        }

        // $lev = array_search($id, $pr_d_lines, true);
    }

    private function pivotal2i(int $n_id, array $r_data, array $pr_data)
    {
        /*
        Referrer ID Passed
        */

        $users = new \App\Models\Users();
        $r_db_data = $r_data;
        $pr_db_data = $pr_data;

        $pr_id = $pr_db_data['id'];
        $pr_d_lines = json_decode($pr_db_data['d_lines'],true);
        $pr_pending_wallet = $pr_db_data['pending_wallet'];

        $fname = $pr_db_data['f_name'];

        if (!isset($pr_d_lines['L2'])) {
            
            echo (' In P2i, Parent Referrer '.$fname.' L3 Null');
            print_r($pr_d_lines);

            $d_lines_lists = [];
            foreach ($pr_d_lines['L1'] as $key => $value) {
                $d_lines_lists[$key] = $value;
            };
            $downlines = [
                'L1' => $d_lines_lists,
                'L2' => [$n_id],
            ];
            $downlines = json_encode($downlines);
            $data = [
                'pending_wallet' => $pr_pending_wallet + 125, //increase referrer pending wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($pr_id, $data);
            $this->pendwallet($pr_id);
            echo('Over with PendWallet');
        }elseif (count($pr_d_lines['L2']) == 1 OR count($pr_d_lines['L2']) > 1) {
            
            echo (' In P2i, Parent Referrer L2 Second & Forever');

            $d_lines_lists1 = [];
            foreach ($pr_d_lines['L1'] as $key => $value) {
                $d_lines_lists1[$key] = $value;
            };
            $d_lines_lists2 = [];
            foreach ($pr_d_lines['L2'] as $key => $value) {
                $d_lines_lists2[$key] = $value;
            };
            $d_lines_lists2[count($d_lines_lists2)] = $n_id;

            $downlines = [
                'L1' => $d_lines_lists1,
                'L2' => $d_lines_lists2,
            ];
            $downlines = json_encode($downlines);
            $data = [
                'pending_wallet' => $pr_pending_wallet + 125, //increase referrer pending wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($pr_id, $data);
            echo('Handing over to PendWallet');
            $this->pendwallet($pr_id);
            echo('Over with PendWallet');
        }
    }

    private function pivotal2ii(int $n_id, array $r_data, array $pr_data, array $gpr_data)
    {
        /*
        Referrer ID Passed
        */

        $users = new \App\Models\Users();
        $r_db_data = $r_data;
        $pr_db_data = $pr_data;
        $gpr_db_data = $gpr_data;

        $pr_id = $pr_db_data['id'];
        $pr_d_lines = json_decode($pr_db_data['d_lines'],true);
        $pr_pending_wallet = $pr_db_data['pending_wallet'];

        if (!isset($pr_d_lines['L2'])) {
            $d_lines_lists = [];
            foreach ($pr_d_lines['L1'] as $key => $value) {
                $d_lines_lists[$key] = $value;
            };
            $downlines = [
                'L1' => $d_lines_lists,
                'L2' => [$n_id],
            ];
            $downlines = json_encode($downlines);
            $data = [
                'pending_wallet' => $pr_pending_wallet + 125, //increase referrer pending wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($pr_id, $data);
            $this->pendwallet($pr_id);
            echo('Over with PendWallet');
        }elseif (count($pr_d_lines['L2']) == 1 OR count($pr_d_lines['L2']) > 1) {
            $d_lines_lists1 = [];
            foreach ($pr_d_lines['L1'] as $key => $value) {
                $d_lines_lists1[$key] = $value;
            };
            $d_lines_lists2 = [];
            foreach ($pr_d_lines['L2'] as $key => $value) {
                $d_lines_lists2[$key] = $value;
            };
            $d_lines_lists2[count($d_lines_lists2)] = $n_id;

            $downlines = [
                'L1' => $d_lines_lists1,
                'L2' => $d_lines_lists2,
            ];
            $downlines = json_encode($downlines);
            $data = [
                'pending_wallet' => $pr_pending_wallet + 125, //increase referrer pending wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($pr_id, $data);
            echo('Handing over to PendWallet');
            $this->pendwallet($pr_id);
            echo('Over with PendWallet');
        }

        $gpr_id = $gpr_db_data['id'];
        $gpr_d_lines = json_decode($gpr_db_data['d_lines'],true);
        $gpr_upgrade_wallet = $gpr_db_data['upgrade_wallet'];

        if (!isset($gpr_d_lines['L3'])) {
            $downlines = [];
            $d_lineKeys = array_keys($gpr_d_lines);
            var_dump($d_lineKeys);
            for ($i=0; $i < count($d_lineKeys); $i++) {
                $g = $d_lineKeys[$i]; 
                foreach ($gpr_d_lines[$g] as $key => $value) {
                    $downlines[$d_lineKeys[$i]][$key] = $value;
                };
            }
            $tmp = [];
            $tmp['L3'][0] =  $n_id;

            $result = array_merge($downlines, $tmp);
            $downlines = json_encode($result);
            $data = [
                'upgrade_wallet' => $gpr_upgrade_wallet + 12500, //increase referrer pending wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($gpr_id, $data);
            $this->upwallet($gpr_id);
            echo('Over with UpWallet');
        }elseif (count($gpr_d_lines['L2']) == 1 OR count($gpr_d_lines['L2']) > 1) {
            $downlines = [];
            $d_lineKeys = array_keys($gpr_d_lines);
            var_dump($d_lineKeys);
            for ($i=0; $i < count($d_lineKeys); $i++) {
                $g = $d_lineKeys[$i]; 
                foreach ($gpr_d_lines[$g] as $key => $value) {
                    $downlines[$d_lineKeys[$i]][$key] = $value;
                };
            }
            $tmp = [];
            $tmp['L3'] = $downlines['L3'];
            $numb = count($tmp['L3']);
            $tmp['L3'][$numb] = $n_id;

            $result = array_merge($downlines, $tmp);
            $downlines = json_encode($result);
            $data = [
                'upgrade_wallet' => $gpr_upgrade_wallet + 12500, //increase referrer pending wallet 
                'd_lines' => $downlines, //add to refferer downlines
            ];
            $users->update($pr_id, $data);
            echo('Handing over to UpWallet');
            $this->upwallet($pr_id);
            echo('Over with UpWallet');
        }
    }

    public function pivotal2(int $id)
    {

        /*
        $r_db_data :: Referrer data
        $p_db_data :: Personal data
        */
        $users = new \App\Models\Users();
        $p_db_data = $users->where('id', $id)->find()[0];
        $p_level = $p_db_data['level'];

        $ref_id = $p_db_data['ref_id'];
        $r_db_data = $users->where('user_id', $ref_id)->find()[0];

        $d_lines = json_decode($r_db_data['d_lines']);

        $r_id = $r_db_data['id'];
        $r_level = $r_db_data['level'];

        $up_wallet = $r_db_data['upgrade_wallet'];
        $pending_wallet = $r_db_data['pending_wallet'];

        $p_wallet = $r_db_data['p_wallet'];
        $c_wallet = $r_db_data['c_wallet'];

        if ($p_level == 2 && $r_level > 2) {
            if ($d_lines->L2 == NULL) {
                $d_lines_lists = [];
                foreach ($d_lines->L1 as $key => $value) {
                    $d_lines_lists[$key] = $value;
                };
                $downlines = [
                    'L1' => $d_lines_lists,
                    'L2' => [$id],
                ];
                $downlines = json_encode($downlines);
                $data = [
                    'pending_wallet' => $pending_wallet + 125, //increase referrer pending wallet 
                    'd_lines' => $downlines, //add to refferer downlines
                ];
                $users->update($r_id, $data);
            }elseif (count($d_lines->L2) > 1) {
                $d_lines_lists1 = [];
                foreach ($d_lines->L1 as $key => $value) {
                    $d_lines_lists1[$key] = $value;
                };
                $d_lines_lists2 = [];
                foreach ($d_lines->L2 as $key => $value) {
                    $d_lines_lists2[$key] = $value;
                };
                $d_lines_lists2[count($d_lines_lists2)] = $id;

                $downlines = [
                    'L1' => $d_lines_lists1,
                    'L2' => $d_lines_lists2,
                ];
                $downlines = json_encode($downlines);
                $data = [
                    'pending_wallet' => $pending_wallet + 125, //increase referrer pending wallet 
                    'd_lines' => $downlines, //add to refferer downlines
                ];
                $users->update($r_id, $data);
                $this->pendwallet($r_id);
            }
        }
    }

    private function upwallet(int $id)
    {
        $users = new \App\Models\Users();
        $balance = $users->where('id', $id)->find()[0]['upgrade_wallet'];
        $lev = $users->where('id', $id)->find()[0]['level'];
        if ($balance == 25000) {
            if($lev == 2){
                return;
            }else{
                $level = 2;
                $data = [
                    'level' => $level,
                    'upgrade_wallet' => 0,
                ];
                $users->update($id, $data);
            }
            return true;
        } elseif ($balance == 50000) {
            $level = 4;
            $data = [
                'level' => $level,
                'upgrade_wallet' => 0,
            ];
            $users->update($id, $data);
        }
    }

    private function pendwallet(int $id)
    {
        echo(' Inside PendWallet');

        $users = new \App\Models\Users();
        $db_data = $users->where('id', $id)->find()[0];
        $p_balance = $db_data['pending_wallet'];
        $prod_balance = $db_data['p_wallet'];
        $cash_balance = $db_data['c_wallet'];
        $lev = $db_data['level'];
        if ($p_balance == 250) {
            echo(' Inside PendWallet 250 is true');
            $level = 3;
            if($lev > 3){
                $level = $lev;
            }
            $data = [
                'level' => $level,
                'p_balance' => $prod_balance+175,
                'c_balance' => $cash_balance+75,
                'pending_wallet' => 0
            ];
            $users->update($id, $data);
        }
    }

    public function transactions()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            echo view('user/header');
            echo view('user/transactions');
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function about()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            echo view('user/header');
            echo view('user/about');
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        $this->login();
    }
    //--------------------------------------------------------------------

    
    // private function pivotal2i(int $n_id, array $r_data, array $pr_data)
    // {
    //     /*
    //     Referrer ID Passed
    //     */

    //     $users = new \App\Models\Users();
    //     $r_db_data = $r_data;
    //     $pr_db_data = $pr_data;

    //     $pr_id = $pr_db_data['id'];
    //     $pr_d_lines = json_decode($pr_db_data['d_lines'],true);
    //     $pr_pending_wallet = $pr_db_data['pending_wallet'];

    //     $fname = $pr_db_data['f_name'];

    //     if (!isset($pr_d_lines['L2'])) {
            
    //         echo (' In P2i, Parent Referrer '.$fname.' L3 Null');
    //         print_r($pr_d_lines);

    //         $d_lines_lists = [];
    //         foreach ($pr_d_lines['L1'] as $key => $value) {
    //             $d_lines_lists[$key] = $value;
    //         };
    //         $downlines = [
    //             'L1' => $d_lines_lists,
    //             'L2' => [$n_id],
    //         ];
    //         $downlines = json_encode($downlines);
    //         $data = [
    //             'pending_wallet' => $pr_pending_wallet + 125, //increase referrer pending wallet 
    //             'd_lines' => $downlines, //add to refferer downlines
    //         ];
    //         $users->update($pr_id, $data);
    //     }elseif (count($pr_d_lines['L2']) == 1 OR count($pr_d_lines['L2']) > 1) {
            
    //         echo (' In P2i, Parent Referrer L2 Second & Forever');

    //         $d_lines_lists1 = [];
    //         foreach ($pr_d_lines['L1'] as $key => $value) {
    //             $d_lines_lists1[$key] = $value;
    //         };
    //         $d_lines_lists2 = [];
    //         foreach ($pr_d_lines['L2'] as $key => $value) {
    //             $d_lines_lists2[$key] = $value;
    //         };
    //         $d_lines_lists2[count($d_lines_lists2)] = $n_id;

    //         $downlines = [
    //             'L1' => $d_lines_lists1,
    //             'L2' => $d_lines_lists2,
    //         ];
    //         $downlines = json_encode($downlines);
    //         $data = [
    //             'pending_wallet' => $pr_pending_wallet + 125, //increase referrer pending wallet 
    //             'd_lines' => $downlines, //add to refferer downlines
    //         ];
    //         $users->update($pr_id, $data);
    //         echo('Handing over to PendWallet');
    //         $this->pendwallet($pr_id);
    //         echo('Over with PendWallet');

    //     }
    // }
}
