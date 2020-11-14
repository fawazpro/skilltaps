<?php

namespace App\Controllers;

use AshleyDawson\SimplePagination\Paginator;
use TeamTNT\TNTSearch\TNTSearch;
use Yabacon\Paystack;


class Pages extends BaseController
{
    public $Bonus = 17000;
    public $Profit = 8000;
    public $P_Bonus = 12000;
    public $C_Bonus = 5000;
    public $PRICE = 25000;
    private $SK = "sk_test_d5db1e8edf8b693c381771783732f2768540ed06";
    private $PK = 'pk_test_85e0f9981d42e18b5401808ccf490b2b344892ea';
    private function tntConfig()
    {
        return [
            'driver'    => 'mysql',
            'host'      => getenv('database.default.localhost'),
            'database'  => getenv('database.default.database'),
            'username'  => getenv('database.default.username'),
            'password'  => getenv('database.default.password'),
            'storage'   => WRITEPATH,
            // 'stemmer'   => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class//optional
        ];
    }

    public function index()
    {
        $session = session();
        if ($session->logged_in == TRUE && $session->admin == TRUE) {
            $this->admindashboard();
        } else if ($session->logged_in == TRUE) {
            $session = session();
            $id = $session->id;
            $users = new \App\Models\Customers();
            $products = new \App\Models\Products();
            $prods = $products->findAll();
            $orders = new \App\Models\Orders();
            $ords = $orders->where(['user_id' => $session->id])->findAll(3);
            foreach ($prods as $key => $value) {
                $prods[$key]['image'] = $this->getFile1($prods[$key]['image']);
            }

            $data = [
                'user' => $users->where('user_id', $id)->find()[0],
                'products' => $prods,
                'dir_img' => getenv('directus'),
                'orders' => $ords,
            ];

            echo view('user/header');
            echo view('user/home', $data);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    private function page()
    {
        if (isset($_GET['page'])) {
            return $_GET['page'];
        } else {
            return 1;
        }
    }

    public function paginatest()
    {

        // Build a mock list of items we want to paginate through
        $items = array(
            'Banana',
            'Apple',
            'Cherry',
            'Lemon',
            'Pear',
            'Watermelon',
            'Orange',
            'Grapefruit',
            'Apple',
            'Cherry',
            'Lemon',
            'Pear',
            'Watermelon',
            'Orange',
            'Pear',
            'Watermelon',
            'Orange',
            'Grapefruit',
            'Apple',
            'Cherry',
            'Lemon',
            'Pear',
            'Watermelon',
            'Orange',
            'Grapefruit',
            'Blackcurrant',
            'Dingleberry',
            'Snosberry',
            'Tomato',
        );

        // Instantiate a new paginator service
        $paginator = new Paginator();

        // Set some parameters (optional)
        $paginator
            ->setItemsPerPage(10) // Give us a maximum of 10 items per page
            ->setPagesInRange(5) // How many pages to display in navigation (e.g. if we have a lot of pages to get through)
        ;

        // Pass our item total callback
        $paginator->setItemTotalCallback(function () use ($items) {
            return count($items);
        });

        // Pass our slice callback
        $paginator->setSliceCallback(function ($offset, $length) use ($items) {
            return array_slice($items, $offset, $length);
        });
        $page = $this->page();
        // Paginate the item collection, passing the current page number (e.g. from the current request)
        $pagination = $paginator->paginate((int) $page);

        // Ok, from here on is where we'd be inside a template of view (e.g. pass $pagination to your view)

        // Iterate over the items on this page
        foreach ($pagination->getItems() as $item) {
            echo $item . '<br />';
        }

        // Let's build a basic page navigation structure
        foreach ($pagination->getPages() as $page) {
            echo '<a href="?page=' . $page . '">' . $page . '</a> ';
        }
    }

    private function getFile($id)
    {
        $client = \Config\Services::curlrequest();
        $url = 'http://localhost/admin.master.terry/skillhubb' . '/files/' . $id;
        $at = 'oIFIIgDji7AQ28TSNm4a3Ccm';
        $response = $client->request('GET', $url, ['query' => ['access_token' => $at]]);

        $body = json_decode($response->getBody());
        return $body->data->filename_disk;
    }

    private function getFile1($id)
    {
        $files = new \App\Models\Files();
        $f_d = $files->where('id', $id)->find()[0];
        return $f_d['filename_disk'];
    }

    private function indiv($id)
    {
        $users = new \App\Models\Customers();
        $indiv = $users->where('user_id', $id)->find()[0];
        return $indiv;
    }

    public function admindashboard()
    {
        $session = session();
        if ($session->logged_in == TRUE && $session->admin == TRUE) {
            $session = session();
            $id = $session->id;
            $users = new \App\Models\Customers();
            $products = new \App\Models\Products();
            $prods = $products->findAll();
            $customers = $users->where('clearance', 1)->findAll();
            $admins = $users->where('clearance', 11)->findAll();
            $orders = new \App\Models\Orders();
            $ords = $orders->findAll();
            $notif = 0;
            $ordes = [];
            foreach ($prods as $key => $value) {
                $prods[$key]['image'] = $this->getFile1($prods[$key]['image']);
            }
            foreach ($ords as $key => $order) {
                if ($order['notif'] == 0) {
                    $notif++;
                    $ordes[$key] = $order;

                    if ($order['type'] == 'c') {
                        $indiv = $this->indiv($order['user_id']);
                        $ordes[$key]['bank'] = $indiv['bank'];
                        $ordes[$key]['acc_num'] = $indiv['acc_num'];
                        $ordes[$key]['acc_name'] = $indiv['acc_name'];
                        $ordes[$key]['phone'] = $indiv['phone'];
                    }
                }
                continue;
            }

            $data = [
                'user' => $users->where('user_id', $id)->find()[0],
                'products' => $prods,
                'prod_count' => count($prods),
                'cust_count' => count($customers),
                'admin_count' => count($admins),
                'order_count' => count($ords),
                'dir_img' => getenv('directus'),
                'orders' => $ordes,
                'ord_count' => $notif
            ];

            echo view('admin/header');
            echo view('admin/home', $data);
            echo view('user/footer');
        } else if ($session->logged_in == TRUE) {
            $dt = [
                'title' => "😠Out of Bound😡",
                'msg' => "You are not authorised to visit this page",
                'url' => "Go to <a href='" . base_url() . "'>dashboard</a>",
            ];
            echo view('user/header');
            echo view('user/message', $dt);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function profit()
    {
        $session = session();
        if ($session->logged_in == TRUE && $session->admin == TRUE) {
            $session = session();
            $id = $session->id;
            $profits = new \App\Models\Profit();
            $profit = $profits->findAll();
            $paginator = new Paginator();
            $paginator
                ->setItemsPerPage(10) // Give us a maximum of 10 items per page
                ->setPagesInRange(5) // How many pages to display in navigation (e.g. if we have a lot of pages to get through)
            ;
            $paginator->setItemTotalCallback(function () use ($profit) {
                return count($profit);
            });
            $paginator->setSliceCallback(function ($offset, $length) use ($profit) {
                return array_slice($profit, $offset, $length);
            });
            $page = $this->page();
            $pagination = $paginator->paginate((int) $page);

            $data = [
                'pagination' => $pagination,
                'current' => $pagination->getCurrentPageNumber(),
                'profits' => $profit,
            ];

            echo view('admin/header');
            echo view('admin/profit', $data);
            echo view('user/footer');
        } else if ($session->logged_in == TRUE) {
            $dt = [
                'title' => "😠Out of Bound😡",
                'msg' => "You are not authorised to visit this page",
                'url' => "Go to <a href='" . base_url() . "'>dashboard</a>",
            ];
            echo view('user/header');
            echo view('user/message', $dt);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function order()
    {
        $session = session();
        if ($session->logged_in == TRUE && $session->admin == TRUE) {
            $session = session();
            $id = $session->id;
            $orders = new \App\Models\Orders();
            $ords = $orders->findAll();
            $notif = 0;
            $ordes = [];
            $standardOrder = [];

            foreach ($ords as $key => $order) {
                $standardOrder[$key] = $order;
                if ($order['type'] == 'c') {
                    $indiv = $this->indiv($order['user_id']);
                    $standardOrder[$key]['bank'] = $indiv['bank'];
                    $standardOrder[$key]['acc_num'] = $indiv['acc_num'];
                    $standardOrder[$key]['acc_name'] = $indiv['acc_name'];
                    $standardOrder[$key]['phone'] = $indiv['phone'];
                }
                if ($order['notif'] == 0) {
                    $notif++;
                    $ordes[$key] = $order;


                    if ($order['type'] == 'c') {
                        $indiv = $this->indiv($order['user_id']);
                        $ordes[$key]['bank'] = $indiv['bank'];
                        $ordes[$key]['acc_num'] = $indiv['acc_num'];
                        $ordes[$key]['acc_name'] = $indiv['acc_name'];
                        $ordes[$key]['phone'] = $indiv['phone'];
                    }
                }
                continue;
            }

            $paginator = new Paginator();
            $paginator
                ->setItemsPerPage(10) // Give us a maximum of 10 items per page
                ->setPagesInRange(5) // How many pages to display in navigation (e.g. if we have a lot of pages to get through)
            ;
            $paginator->setItemTotalCallback(function () use ($standardOrder) {
                return count($standardOrder);
            });
            $paginator->setSliceCallback(function ($offset, $length) use ($standardOrder) {
                return array_slice($standardOrder, $offset, $length);
            });
            $page = $this->page();
            $pagination = $paginator->paginate((int) $page);

            $data = [
                'orders' => $ordes,
                'ordes' => $standardOrder,
                'pagination' => $pagination,
                'count' => $notif,
                'current' => $pagination->getCurrentPageNumber(),
            ];
            echo view('admin/header');
            echo view('admin/order', $data);
            echo view('user/footer');
        } else if ($session->logged_in == TRUE) {
            $orders = new \App\Models\Orders();
            $ords = $orders->where('user_id',$session->id)->findAll(3);
            var_dump($ords);
            $data = [
                'orders' => $ords,
            ];
            echo view('user/header');
            echo view('user/transactions', $data);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function customers()
    {
        $session = session();
        if ($session->logged_in == TRUE && $session->admin == TRUE) {
            $session = session();
            $id = $session->id;
            $users = new \App\Models\Customers();
            $user = $users->findAll();
            foreach ($user as $key => $usr) {
                $user[$key]['downlines'] = $users->where('ref_id', $usr['user_id'])->findAll();
            }


            $paginator = new Paginator();
            $paginator
                ->setItemsPerPage(10) // Give us a maximum of 10 items per page
                ->setPagesInRange(5) // How many pages to display in navigation (e.g. if we have a lot of pages to get through)
            ;
            $paginator->setItemTotalCallback(function () use ($user) {
                return count($user);
            });
            $paginator->setSliceCallback(function ($offset, $length) use ($user) {
                return array_slice($user, $offset, $length);
            });
            $page = $this->page();
            $pagination = $paginator->paginate((int) $page);

            $data = [
                'customers' => $user,
                'pagination' => $pagination,
                'current' => $pagination->getCurrentPageNumber(),
            ];

            echo view('admin/header');
            echo view('admin/customer', $data);
            echo view('user/footer');
        } else if ($session->logged_in == TRUE) {
            $dt = [
                'title' => "😠Out of Bound😡",
                'msg' => "You are not authorised to visit this page",
                'url' => "Go to <a href='" . base_url() . "'>dashboard</a>",
            ];
            echo view('user/header');
            echo view('user/message', $dt);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function fulfillwithdraw()
    {
        $session = session();
        if ($session->logged_in == TRUE && $session->admin == TRUE) {
            $session = session();
            $id = $session->id;
            $orders = new \App\Models\Orders();
            $incoming = $this->request->getPost();
            $data = [
                'notif' => 1,
                'status' => 'Completed',
            ];
            $ords = $orders->update($incoming['id'], $data);
            if ($ords) {
                $this->order();
            }
        } else if ($session->logged_in == TRUE) {
            $dt = [
                'title' => "😠Out of Bound😡",
                'msg' => "You are not authorised to visit this page",
                'url' => "Go to <a href='" . base_url() . "'>dashboard</a>",
            ];
            echo view('user/header');
            echo view('user/message', $dt);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function fulfillorder()
    {
        $session = session();
        if ($session->logged_in == TRUE && $session->admin == TRUE) {
            $session = session();
            $id = $session->id;
            $orders = new \App\Models\Orders();
            $incoming = $this->request->getPost();
            $data = [
                'notif' => 1,
                'status' => $incoming['status'],
            ];
            $ords = $orders->update($incoming['id'], $data);
            if ($ords) {
                $this->order();
            }
        } else if ($session->logged_in == TRUE) {
            $dt = [
                'title' => "😠Out of Bound😡",
                'msg' => "You are not authorised to visit this page",
                'url' => "Go to <a href='" . base_url() . "'>dashboard</a>",
            ];
            echo view('user/header');
            echo view('user/message', $dt);
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

    public function bootstrap()
    {
        $this->productTNTloader();
    }

    public function productTNTloader()
    {
        $tnt = new TNTSearch;
        $tnt->loadConfig($this->tntConfig());

        $indexer = $tnt->createIndex('market.index');
        $indexer->query('SELECT id, name, category, details FROM products;');
        //$indexer->setLanguage('german');
        $indexer->run();
    }

    public function search()
    {
        $incoming = $this->request->getGet();
        $keyword = $incoming['keyword'];
        $tnt = new TNTSearch;
        $tnt->loadConfig($this->tntConfig());
        $tnt->selectIndex("market.index");
        $tnt->fuzziness = true;

        $res = $tnt->search($keyword, 10);

        $products = new \App\Models\Products();
        $searches = $products->whereIn('id', $res['ids'])->findAll();
        foreach ($searches as $key => $value) {
            $searches[$key]['image'] = $this->getFile1($searches[$key]['image']);
        };
        $paginator = new Paginator();
        $paginator
            ->setItemsPerPage(10) // Give us a maximum of 10 items per page
            ->setPagesInRange(5) // How many pages to display in navigation (e.g. if we have a lot of pages to get through)
        ;
        $paginator->setItemTotalCallback(function () use ($searches) {
            return count($searches);
        });
        $paginator->setSliceCallback(function ($offset, $length) use ($searches) {
            return array_slice($searches, $offset, $length);
        });
        $page = $this->page();
        $pagination = $paginator->paginate((int) $page);

        $data = [
            'hits' => $res['hits'],
            'dir_img' => getenv('directus'),
            'pagination' => $pagination,
            'current' => $pagination->getCurrentPageNumber(),
        ];
        echo view('user/header');
        echo view('user/search', $data);
        echo view('user/footer');
    }

    public function register()
    {
        echo view('user/authheader');
        echo view('user/register');
    }

    public function makePayment($id, $url)
    {
        echo view('user/authheader');
        echo view('user/payment', ['id' => $id, 'url' => $url]);
    }

    private function verifyPayment($ref, $id)
    {
        $trans = new \App\Models\Tranx();
        $reference = $ref;
        if (!$reference) {
            die('No reference supplied');
        }

        // initiate the Library's Paystack Object
        $paystack = new \Yabacon\Paystack($this->SK);
        try {
            // verify using the library
            $tranx = $paystack->transaction->verify([
                'reference' => $reference, // unique to transactions
            ]);
        } catch (\Yabacon\Paystack\Exception\ApiException $e) {
            print_r($e->getResponseObject());
            die($e->getMessage());
        }

        if ('success' === $tranx->data->status) {
            $data = [
                'status' => 'Payment successful'
            ];
            $trans->update($id, $data);
            return TRUE;
        }
    }

    private function payment($email, $user)
    {
        $trans = new \App\Models\Tranx();
        $amount = $this->PRICE * 100;
        $reference = uniqid("skilltaps");
        $paystack = new \Yabacon\Paystack($this->SK);
        try {
            $tranx = $paystack->transaction->initialize([
                'amount' => $amount,       // in kobo
                'email' => $email,         // unique to customers
                'reference' => $reference, // unique to transactions
            ]);
        } catch (\Yabacon\Paystack\Exception\ApiException $e) {
            print_r($e->getResponseObject());
            die($e->getMessage());
        }

        // store transaction reference so we can query in case user never comes back
        // perhaps due to network issue
        $data = [
            'reference' => $tranx->data->reference,
            'url' => $tranx->data->authorization_url,
            'user_id' => $user,
            'email' => $email,
            'status' => 'initiated'
        ];
        $trans->save($data);
        var_dump($tranx->data->reference);
        return $tranx->data->authorization_url;
        // redirect to page so User can pay
        // return redirect()->to(base_url());
    }

    public function postregister()
    {
        $users = new \App\Models\Customers();
        $incoming = $this->request->getPost();
        $ref_id = $incoming['ref'];
        $user_id = 'SH' . substr(uniqid(), -5);
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
                'clearance' => 1,
                'password' => hash('sha1', $incoming['pass'], false),
            ];

            if (null !== ($users->insert($data))) {
                $paymenturl = $this->payment($incoming['email'], $user_id);
                $this->makePayment($user_id, $paymenturl);
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
        $trans = new \App\Models\Tranx();
        $incoming = $this->request->getPost();
        $data = [
            'email' => $incoming['email'],
            'password' => hash('sha1', $incoming['pass'], false),
        ];
        $result = $users->where($data)->find();
        if ($result) {
            if ($result[0]['paid'] && $result[0]['clearance'] == 1) {
                $ses_data = [
                    'id' => $result[0]['user_id'],
                    'f_name' => $result[0]['fname'],
                    'email' => $result[0]['email'],
                    'paid' => $result[0]['paid'],
                    'p_wallet' => $result[0]['p_wallet'],
                    'logged_in' => TRUE,
                ];
                $session = session();
                $session->set($ses_data);
                // $this->index();
                return redirect()->to(base_url());
            } else if ($result[0]['paid'] && $result[0]['clearance'] == 11) {
                $ses_data = [
                    'id' => $result[0]['user_id'],
                    'f_name' => $result[0]['fname'],
                    'email' => $result[0]['email'],
                    'paid' => $result[0]['paid'],
                    'p_wallet' => $result[0]['p_wallet'],
                    'admin' => TRUE,
                    'logged_in' => TRUE,
                ];
                $session = session();
                $session->set($ses_data);
                // $this->index();
                return redirect()->to(base_url());
            } else {
                $u_db = $trans->where('user_id', $result[0]['user_id'])->find()[0];
                if ($this->verifyPayment($u_db['reference'], $u_db['id'])) {
                    if($this->processpay($result[0]['user_id'])){
                    $ses_data = [
                        'id' => $result[0]['user_id'],
                        'f_name' => $result[0]['fname'],
                        'email' => $result[0]['email'],
                        'paid' => 1,
                        'p_wallet' => $result[0]['p_wallet'],
                        'logged_in' => TRUE,
                    ];
                    $session = session();
                    $session->set($ses_data);
                    return redirect()->to(base_url());}
                } else {
                    $paymenturl = $u_db['url'];
                    $this->makePayment($result[0]['user_id'], $paymenturl);
                }
            }
        } else {
            $data = [
                'title'=>'Login Failed 💔',
                'msg'=>'Wrong email or password provided',
                'url'=>base_url()
            ];
            $this->msg($data);
        }
    }

    public function msg($data)
    {
        echo view('user/authheader');
        echo view('user/redirect',$data);
    }

    public function processpay($id)
    {
        // <a href="<?= base_url('pp?sku='.$id)
        $users = new \App\Models\Customers();
        $data = [
            'paid' => 1
        ];
        $p_db = $users->where('user_id', $id)->find()[0];
        $users->update($id, $data);
        $this->addtowallet($p_db['ref_id']);
        $this->credit($id);
        return TRUE;
    }

    private function credit($id)
    {
        $profit = new \App\Models\Profit();
        $data = [
            'customer' => $id,
            'amount' => $this->Profit
        ];
        $profit->save($data);
        return;
    }

    private function addtowallet($id)
    {
        $users = new \App\Models\Customers();
        $db_data = $users->where('user_id', $id)->find()[0];
        $data = [
            'p_wallet' => $db_data['p_wallet'] + $this->P_Bonus,
            'c_wallet' => $db_data['c_wallet'] + $this->C_Bonus,
        ];
        $users->update($id, $data);
        return;
    }

    public function profile()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $users = new \App\Models\Customers();
            $user = $users->where(['user_id' => $session->id])->find()[0];

            $data = [
                'user' => $user,
                'banks' => [
                    array('id' => '1', 'name' => 'Access Bank', 'code' => '044'),
                    array('id' => '2', 'name' => 'Citibank', 'code' => '023'),
                    array('id' => '3', 'name' => 'Diamond Bank', 'code' => '063'),
                    array('id' => '4', 'name' => 'Dynamic Standard Bank', 'code' => ''),
                    array('id' => '5', 'name' => 'Ecobank Nigeria', 'code' => '050'),
                    array('id' => '6', 'name' => 'Fidelity Bank Nigeria', 'code' => '070'),
                    array('id' => '7', 'name' => 'First Bank of Nigeria', 'code' => '011'),
                    array('id' => '8', 'name' => 'First City Monument Bank', 'code' => '214'),
                    array('id' => '9', 'name' => 'Guaranty Trust Bank', 'code' => '058'),
                    array('id' => '10', 'name' => 'Heritage Bank Plc', 'code' => '030'),
                    array('id' => '11', 'name' => 'Jaiz Bank', 'code' => '301'),
                    array('id' => '12', 'name' => 'Keystone Bank Limited', 'code' => '082'),
                    array('id' => '13', 'name' => 'Providus Bank Plc', 'code' => '101'),
                    array('id' => '14', 'name' => 'Polaris Bank', 'code' => '076'),
                    array('id' => '15', 'name' => 'Stanbic IBTC Bank Nigeria Limited', 'code' => '221'),
                    array('id' => '16', 'name' => 'Standard Chartered Bank', 'code' => '068'),
                    array('id' => '17', 'name' => 'Sterling Bank', 'code' => '232'),
                    array('id' => '18', 'name' => 'Suntrust Bank Nigeria Limited', 'code' => '100'),
                    array('id' => '19', 'name' => 'Union Bank of Nigeria', 'code' => '032'),
                    array('id' => '20', 'name' => 'United Bank for Africa', 'code' => '033'),
                    array('id' => '21', 'name' => 'Unity Bank Plc', 'code' => '215'),
                    array('id' => '22', 'name' => 'Wema Bank', 'code' => '035'),
                    array('id' => '23', 'name' => 'Zenith Bank', 'code' => '057')
                ],
            ];
            // var_dump($ords);
            echo view('user/header');
            echo view('user/profile', $data);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function transactions()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $orders = new \App\Models\Orders();
            $ords = $orders->where('user_id',$session->id)->findAll();

            $data = [
                'orders' => $ords,
            ];
            // var_dump($ords);
            echo view('user/header');
            echo view('user/transactions', $data);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function market()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $id = $session->id;
            $users = new \App\Models\Customers();
            $products = new \App\Models\Products();
            $prods = $products->findAll();
            foreach ($prods as $key => $value) {
                $prods[$key]['image'] = $this->getFile1($prods[$key]['image']);
            };
            $paginator = new Paginator();
            $paginator
                ->setItemsPerPage(20) // Give us a maximum of 10 items per page
                ->setPagesInRange(5) // How many pages to display in navigation (e.g. if we have a lot of pages to get through)
            ;
            $paginator->setItemTotalCallback(function () use ($prods) {
                return count($prods);
            });
            $paginator->setSliceCallback(function ($offset, $length) use ($prods) {
                return array_slice($prods, $offset, $length);
            });
            $page = $this->page();
            $pagination = $paginator->paginate((int) $page);

            $data = [
                'user' => $users->where('user_id', $id)->find()[0],
                'dir_img' => getenv('directus'),
                'pagination' => $pagination,
                'current' => $pagination->getCurrentPageNumber(),
                'products' => $prods,
            ];
            echo view('user/header');
            echo view('user/market', $data);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function details()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $id = $session->id;
            $sku = $this->request->getGet('sku');
            $users = new \App\Models\Customers();
            $products = new \App\Models\Products();
            $prod = $products->where('id', $sku)->find()[0];
            $prod['image'] = $this->getFile1($prod['image']);
            $data = [
                'user' => $users->where('user_id', $id)->find()[0],
                'product' => $prod,
                'dir_img' => getenv('directus'),
            ];
            echo view('user/header');
            echo view('user/single', $data);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function summary()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $id = $session->id;
            $users = new \App\Models\Customers();
            $data = [
                'user' => $users->where('user_id', $id)->find()[0],
            ];

            echo view('user/header');
            echo view('user/summary', $data);
            echo view('user/footer');
        } else {
            $this->login();
        }
    }

    public function pay()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $id = $session->id;

            $orders = new \App\Models\Orders();

            $users = new \App\Models\Customers();
            $userdb = $users->where('user_id', $id)->find()[0];
            $user_wallet = $userdb['p_wallet'];

            $incoming = $this->request->getPost();
            $price = $incoming['price'];
            $ord = json_decode(urldecode($incoming['order']));
            $order = [];
            foreach ($ord as $key => $ord) {
                $order[$key] = [
                    'name' => $ord->name,
                    'price' => $ord->price,
                    'count' => $ord->count,
                    'total' => $ord->total,
                ];
            }


            if ($user_wallet > $price) {
                $user_data = [
                    'p_wallet' => $user_wallet - $price
                ];
                $user_update = $users->update($id, $user_data);
                $data = [
                    'user_id' => $userdb['user_id'],
                    'orders' => json_encode($order),
                    'type' => 'p',
                    'status' => 'Pending',
                    'notif' => 0,
                ];
                $admin_update = $orders->insert($data);
                $dt = [
                    'title' => "Congratulation🎊🎉",
                    'msg' => "Your order was successful",
                    'url' => "Go to <a class='clear-cart' href='" . base_url() . "'>dashboard</a>",
                ];
                if ($admin_update) {
                    echo view('user/header');
                    echo view('user/message', $dt);
                    echo view('user/footer');
                }
            } else {
                $msg = 'Insufficient Balance in Product Wallet';
                echo ($msg);
            }
        } else {
            $this->login();
        }
    }

    public function personalinfo()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $id = $session->id;
            $users = new \App\Models\Customers();
            $incoming = $this->request->getPost();
            $res = $users->update($id, $incoming);
            if ($res) {
                $dt = [
                    'title' => "Successful✨",
                    'msg' => "Your profile update was successful",
                    'url' => "Go to <a href='" . base_url('profile') . "'>profile</a>",
                ];
                echo view('user/header');
                echo view('user/message', $dt);
                echo view('user/footer');
            } else {
                $dt = [
                    'title' => "😢 Sorry 😒",
                    'msg' => "Your profile update was unsuccessful",
                    'url' => "Go to <a href='" . base_url('profile') . "'>profile</a>",
                ];
                echo view('user/header');
                echo view('user/message', $dt);
                echo view('user/footer');
            }
        } else {
            $this->login();
        }
    }

    public function withdraw()
    {
        $session = session();
        if ($session->logged_in == TRUE) {
            $id = $session->id;

            $orders = new \App\Models\Orders();

            $users = new \App\Models\Customers();
            $userdb = $users->where('user_id', $id)->find()[0];
            $user_wallet = $userdb['c_wallet'];

            $incoming = $this->request->getPost();
            $price = $incoming['amount'] + ($incoming['amount']*0.025);

            if ($user_wallet > $price) {
                $user_data = [
                    'c_wallet' => $user_wallet - $price
                ];
                $user_update = $users->update($id, $user_data);
                $data = [
                    'user_id' => $userdb['user_id'],
                    'orders' => $price,
                    'status' => 'Pending',
                    'type' => 'c',
                    'notif' => 0,
                ];
                $admin_update = $orders->insert($data);
                $dt = [
                    'title' => "Congratulation🎊🎉",
                    'msg' => "Your withdrawal was successful",
                    'url' => "Go to <a href='" . base_url() . "'>dashboard</a>",
                ];
                if ($admin_update) {
                    echo view('user/header');
                    echo view('user/message', $dt);
                    echo view('user/footer');
                }
            } else {
                $dt = [
                    'title' => "Sorry🙇‍♀️🙇‍♂",
                    'msg' => "You have insufficient Balance in your Cash Wallet",
                    'url' => "Go to <a class='clear-cart' href='" . base_url() . "'>dashboard</a>",
                ];
                echo view('user/header');
                echo view('user/message', $dt);
                echo view('user/footer');
            }
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
        // $this->login();
        return redirect()->to(base_url());
    }
    //--------------------------------------------------------------------

}
