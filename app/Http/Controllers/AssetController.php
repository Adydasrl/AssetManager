<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Asset;

use App\Models\Customer;

use App\Models\Device;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;


class AssetController extends Controller
{

    function createAsset(Request $request) {
        date_default_timezone_set("Europe/Rome");
        $device_type=isset($request->new_device_name)?$request->new_device_name:$request->device_type;
        $abb_device=isset($request->dev_abb)?$request->dev_abb:$device_type;
        $type=$request->receiver_type=="inner"?"interno":"cliente";
        $company_name=$type=="interno"?"Adyda":(isset($request->new_company_name)?$request->new_company_name:$request->company_name);
        $owner=$type=='cliente'?null:(isset($request->new_dest_name)?$request->new_dest_name:$request->dest_name);
        $company_id=$this->getCompanyID($company_name);


        if(isset($request->new_device_name)) {
            $this->createDevice($device_type,$abb_device);
        }

        $dev_code=$this->codeDevice($abb_device,$company_name);

        if($type==="interno") {
            Asset::create([
                'codifica_dispositivo' => $dev_code,
                'tipo_dispositivo' => $abb_device,
                'serial_number' => $request->serial_num,
                'type' => $type,
                'owner_name' => $owner
            ]);
        }
        else {
            Asset::create([
                'codifica_dispositivo' => $dev_code,
                'tipo_dispositivo' => $abb_device,
                'customer_id' => $company_id,
                'serial_number' => $request->serial_num,
                'type' => $type
            ]);
        }
        return redirect("/asset_form")->with("scss","Registrato asset {$dev_code}");
    }

    function createCompany($company_name) {
        date_default_timezone_set("Europe/Rome");
        $id=Customer::insertGetId([
            'nome_azienda' => $company_name,
            'alias' => $this->createAlias($company_name),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return $id;
    }

    function createDevice($device_type,$abb_device) {
        date_default_timezone_set("Europe/Rome");
        Device::create([
            'dispositivo' => $device_type,
            'abbreviazione' => $abb_device
        ]);
    }

    function createAlias($company_name) {
        $name=explode(" ",$company_name);
        if(count($name)>1) {
            $alias='';
            for($k=0;$k<count($name);$k++) {
                $alias.=strtoupper(substr($name[$k],0,1));
            }
            return $alias;
        } else {
            return strtoupper(substr($name[0],0,3));
        }
    }

    function codeDevice($device_type,$company_name) {
        $alias=$this->createAlias($company_name);
        $company_id=$this->getCompanyID($company_name);
        //$sigla=Device::where('abbreviazione','=',$device_type)->get();
        $asset_num=isset($company_id)? Asset::where('customer_id','=',$company_id)->where('tipo_dispositivo','=',$device_type)->count():
                                       Asset::whereNull('customer_id')->where('owner_name',"!=",null)->where('tipo_dispositivo','=',$device_type)->count();
        $code_num=$asset_num+1>=10?(string)($asset_num+1):"0".(string)($asset_num+1);
        $code=$alias."-".$device_type.$code_num; //$code=$alias."-".$sigla[0]->abbreviazione.$code_num;
        return $code;
    }

    function codeNaDevice($device_type) {
      $count=Asset::where("codifica_dispositivo","LIKE","%ADY-NA-{$device_type}%")->count();
      $count+=1;
      if($count<10) {
       return "ADY-NA-{$device_type}0{$count}";
      } else {
       return "ADY-NA-{$device_type}{$count}";
      }
    }

    function getCompanyID($company_name) {
        if($company_name==="Adyda") {
            return null;
        }
        else {

            $company_id=Customer::select('id')->where('nome_azienda','=',$company_name)->get();

            if(!$company_id->isEmpty()) {
                return $company_id[0]->id;
            }
            else {
                return $this->createCompany($company_name);
            }
        }
    }

    function loadDeviceSelect() {
        $options = Device::select("*")->get();

        return json_encode($options);
    }

    function loadCompanySelect() {
        $options=Customer::select("id","nome_azienda")->get();
        return json_encode($options);
    }

    function loadNameSelect() {
        $options=Asset::select("owner_name")->distinct()->where("owner_name","!=",null)->get();
        return json_encode($options);
    }

    function getAsset($value) {
        if($value=="inner") {
            $list=Asset::select("codifica_dispositivo as codifica","serial_number as serial","tipo_dispositivo as tipo","owner_name as nome_azienda","id")->where("owner_name","!=",null)->orderBy('tipo')->get();
            return json_encode($list);
        }
        else if($value=="na") {
           $list=Asset::select("codifica_dispositivo as codifica","serial_number as serial","tipo_dispositivo as tipo","id")->where("codifica_dispositivo","like","ADY-NA%")->orderBy('tipo')->get();
           return json_encode($list);
        }
        else {
            $list=Asset::select("codifica_dispositivo as codifica","serial_number as serial","tipo_dispositivo as tipo","nome_azienda","assets.id")->join("customers","customer_id","=","customers.id")->where("customer_id","=",$value)->orderBy('tipo')->get(); //second: 'customers.id'
            return json_encode($list);
        }
    }

    function ch_pwd($id,Request $request) {
        $password=User::select("password")->where("id","=",value: $id)->first()->password;
        if(Hash::check($request->old_pw,$password) && $request->new_pw==$request->cnf_pw && preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',$request->new_pw)) {
            User::where('id',$id)->update(['password'=>Hash::make($request->new_pw)]);
            return redirect('mng_user')->with('scss','Password modificata con successo');
        }
        else {
            return redirect('mng_user')->with('fail','Qualcosa è andato storto; assicurarsi di inserire tutti i campi correttamente');
        }
    }

    function login(Request $request) {
       $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']])) {
            return redirect('asset_manager');
        }
        else {
            return redirect('/')->with('fail',"Credenziali Errate!!!");
        }
    }
    function new_usr(Request $request) {
        $data = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        if($data) {
            User::create([
                'name' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'])
            ]);

            return redirect("ins_new_usr")->with('scss',"Utente inserito correttamente");
        }
        else {
            return redirect("ins_new_usr")->with('fail',"Qualcosa è andato storto; controlla se hai inserito i dati nel formato corretto");
        }
    }
    function del_asset($id) {
       Asset::where('id',$id)->update([
         'codifica_dispositivo' => $this->codeNaDevice(Asset::select("tipo_dispositivo as dispositivo")->where('id',$id)->first()->dispositivo), //'codifica_dispositivo' => $this->codeNaDevice((Asset::select("tipo_dispositivo as dispositivo")->where('id',$id)->get())[0]->dispositivo),
         'type' => 'interno',
         'customer_id' => null,
         'owner_name' => null
       ]);

       return redirect("asset_list");
    }
    function ass_asset($id,Request $req) {

       if($req->sel_dest==="inner") {
          Asset::where('id',$id)->update([
            'codifica_dispositivo' => $this->codeDevice(Asset::select("tipo_dispositivo as dispositivo")->where('id',$id)->first()->dispositivo,"Adyda"), //'codifica_dispositivo' => $this->codeDevice((Asset::select("tipo_dispositivo as dispositivo")->where('id',$id)->get())[0]->dispositivo,"Adyda"),
            'type' => 'interno',
            'owner_name' => $req->dest_name
          ]);
       }
       else {
          Asset::where('id',$id)->update([
             'codifica_dispositivo' => $this->codeDevice(Asset::select("tipo_dispositivo as dispositivo")->where('id',$id)->first()->dispositivo,Customer::select("nome_azienda")->where('id',$req->comp_id)->first()->nome_azienda), //'codifica_dispositivo' => $this->codeDevice((Asset::select("tipo_dispositivo as dispositivo")->where('id',$id)->get())[0]->dispositivo,(Customer::select("nome_azienda")->where('id',$req->comp_id)->get())[0]->nome_azienda),
             'type' => 'cliente',
             'customer_id' => $req->comp_id
          ]);
       }
       return response()->json([
           'success' => true
       ]);
    }
}
