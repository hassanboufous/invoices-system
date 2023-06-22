<?php

namespace App\Http\Livewire;

use Exception;
use App\Models\Grade;
use Livewire\Component;
use App\Models\MyParent;
use App\Models\Religion;
use App\Models\BloodType;
use App\Models\Nationality;
use Livewire\WithFileUploads;
use App\Models\ParentAttachment;
use App\traits\UploadImg;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;

class AddParent extends Component
{

    use WithFileUploads;
    use UploadImg;

    public $successMessage = '';
    public  $catchError,
            $updateMode = false,
            $show_table = true,
            $photos,
            $parent_id ;

    public $currentStep = 1,
        // Father_INPUTS ----------------------------------
        $email                  , $password,
        $father_name            , $father_name_en,
        $father_nationality_id  , $father_passport,
        $father_phone           , $father_job ,
        $father_job_en          , $father_identity,
        $father_blood_type_id   , $father_address,
        $father_religion_id     ,
        // Mother_INPUTS ---------------------------------
        $mother_name            , $mother_name_en,
        $mother_identity        , $mother_passport,
        $mother_phone           , $mother_job, $mother_job_en,
        $mother_nationality_id  , $mother_blood_type_id,
        $mother_address         , $mother_religion_id;

    // realtime inputs validation
    public function updated($propertyName)
    {
        // $this->validateOnly($propertyName, [
        //     'email' => 'required|email',
        //     'father_nationality_id' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
        //     'father_passport' => 'min:10|max:10',
        //     'father_phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        //     'mother_nationality_id' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
        //     'mother_passport' => 'min:10|max:10',
        //     'mother_phone' => 'regex:/^([0-9\s\-\+\(\)]*)$/|min:10'
        // ]);
    }


    public function render()
    {
        return view('livewire.add-parent', [
            'nationalities' => Nationality::all(),
            'blood_types'   => BloodType::all(),
            'religions'     => Religion::all(),
            'my_parents'    => MyParent::all(),
        ]);

    }

    public function showformadd(){
        $this->show_table = false;
    }


    //validate while submiting the first step
    public function firstStepSubmit()
    {
        $this->validate([
             'email' => 'required|unique:my_parents,email,'.$this->id,
             'password' => 'required',
             'father_name' => 'required',
             'father_name_en' => 'required',
    //         'father_job' => 'required',
    //         'father_job_en' => 'required',
    //         'father_nationality_id' => 'required|unique:my_parents,father_nationality_id,' . $this->id,
    //         'father_passport' => 'required|unique:my_parents,father_passport,' . $this->id,
    //         'father_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
    //         'father_nationality_id' => 'required',
    //         'father_blood_type_id' => 'required',
    //         'father_religion_id' => 'required',
    //         'father_address' => 'required',
        ]);

        $this->currentStep = 2;
    }

    //validate while submiting the second step
    public function secondStepSubmit()
    {

        $this->validate([
            'mother_name' => 'required',
             'mother_name_en' => 'required',
        //     'mother_nationality_id' => 'required|unique:my_parents,mother_nationality_id,' . $this->id,
        //     'mother_passport' => 'required|unique:my_parents,mother_passport,' . $this->id,
        //     'mother_phone' => 'required',
        //     'mother_job' => 'required',
        //     'mother_job_en' => 'required',
        //     'mother_nationality_id' => 'required',
        //     'mother_blood_type_id' => 'required',
        //     'mother_religion_id' => 'required',
        //     'mother_address' => 'required',
        ]);

        $this->currentStep = 3;
    }

    public function submitForm(){

        try {
            $myparent = new MyParent();
            // Father_INPUTS -----------------------------------------------------------------------------
            $myparent->email                 = $this->email;
            $myparent->password              = Hash::make($this->password);
            $myparent->father_name           = ['en' => $this->father_name_en, 'ar' => $this->father_name];
            $myparent->father_job            = ['en' => $this->father_job_en,  'ar' => $this->father_job ];
            $myparent->father_passport       = $this->father_passport;
            $myparent->father_identity       = $this->father_identity;
            $myparent->father_phone          = $this->father_phone;
            $myparent->father_blood_type_id  = $this->father_blood_type_id;
            $myparent->father_nationality_id = $this->father_nationality_id;
            $myparent->father_religion_id    = $this->father_religion_id;
            $myparent->father_address        = $this->father_address;

            // Mother_INPUTS -------------------------------------------------------------------------------
            $myparent->mother_name           = ['en' => $this->mother_name_en, 'ar' => $this->mother_name];
            $myparent->mother_job            = ['en' => $this->mother_job_en,  'ar' => $this->mother_job];
            $myparent->mother_phone          = $this->mother_phone;
            $myparent->mother_passport       = $this->mother_passport;
            $myparent->mother_nationality_id = $this->mother_nationality_id;
            $myparent->mother_blood_type_id  = $this->mother_blood_type_id;
            $myparent->mother_religion_id    = $this->mother_religion_id;
            $myparent->mother_address        = $this->mother_address;
            $myparent->save();

            // Uploading parent attachments if any ------------------------------------------------
             if (!empty($this->photos)){
                foreach ($this->photos as $photo) {
                    $file_path = $this->uplodIgmage($photo,$this->father_phone);
                  // $photo->storeAs($this->father_phone, $photo->getClientOriginalName(),'public');
                    ParentAttachment::create([
                         'file_path' => $file_path ,
                         'parent_id' => MyParent::latest()->first()->id
                    ]);
                }
              }
            session()->flash('success',trans('messages.added'));
            $this->clearForm();
            $this->currentStep = 1;
        }

        catch (Exception $e) {
            $this->catchError = $e->getMessage();
        };

    }


    public function edit($id) {

        $this->show_table = false ; // switch the info table by the form
        $this->updateMode = true ; // switch add buttons by edit buttons

        $myparent         = MyParent::where('id',$id)->first();

        $this->parent_id             = $id;
        $this->email                 = $myparent->email;
        $this->password              = $myparent->password;
        $this->father_name           = $myparent->getTranslation('father_name', 'ar');
        $this->father_name_en        = $myparent->getTranslation('father_name', 'en');
        $this->father_job            = $myparent->getTranslation('father_job',  'ar');
        $this->father_job_en         = $myparent->getTranslation('father_job',  'en');
        $this->father_passport       = $myparent->father_passport;
        $this->father_identity       = $myparent->father_identity;
        $this->father_phone          = $myparent->father_phone;
        $this->father_nationality_id = $myparent->father_nationality_id;
        $this->father_blood_type_id  = $myparent->father_blood_type_id;
        $this->father_religion_id    = $myparent->father_religion_id;
        $this->father_address        = $myparent->father_address;

        $this->mother_name          = $myparent->getTranslation('mother_name', 'ar');
        $this->mother_name_en       = $myparent->getTranslation('father_name', 'en');
        $this->mother_job           = $myparent->getTranslation('mother_job',  'ar');;
        $this->mother_job_en        = $myparent->getTranslation('mother_job',  'en');
        $this->mother_passport      = $myparent->mother_passport;
        $this->mother_phone         = $myparent->mother_phone;
        $this->mother_nationality_id   = $myparent->mother_nationality_id;
        $this->mother_blood_type_id    = $myparent->mother_blood_type_id;
        $this->mother_religion_id      = $myparent->mother_religion_id;
        $this->mother_address          = $myparent->mother_address;
    }

    // edit father info and submit step 1
    public function firstStepSubmit_edit()
    {
        $this->updateMode = true;
        $this->currentStep = 2;

    }

     // edit mother info and submit step 2
    public function secondStepSubmit_edit()
    {
        $this->updateMode = true;
        $this->currentStep = 3;

    }
    // submit all (edited)
    public function submitForm_edit(){

        if ($this->parent_id){
            $parent = MyParent::findOrFail($this->parent_id);
            $parent->update([
               'email'                  => $this->email,
               'password'               => $this->password,
               'father_name'            => ['ar' => $this->father_name,'en' => $this->father_name_en] ,
               'father_job'             => ['ar' => $this->father_job,'en' => $this->father_job_en],
               'father_passport'        => $this->father_passport,
               'father_identity'        => $this->father_identity,
               'father_phone'           => $this->father_phone,
               'father_nationality_id'  => $this->father_nationality_id,
               'father_blood_type_id'   => $this->father_blood_type_id,
               'father_religion_id'     => $this->father_religion_id,
               'father_address'         => $this->father_address,

               'mother_name'            => ['en' => $this->mother_name_en, 'ar' => $this->mother_name],
               'mother_job'             => ['en' => $this->mother_job_en,  'ar' => $this->mother_job],
               'mother_passport'        => $this->mother_passport,
               'mother_phone'           => $this->mother_phone,
               'mother_nationality_id'  => $this->mother_nationality_id,
               'mother_blood_type_id'   => $this->mother_blood_type_id,
               'mother_religion_id'     => $this->mother_religion_id,
               'mother_address'         => $this->mother_address,

            ]);
            //  if (!empty($this->photos)){
            //     foreach ($this->photos as $photo) {
            //         $file_path = $this->uplodIgmage($photo,$this->father_phone);
            //       // $file_path = $photo->storeAs($this->father_phone, $photo->getClientOriginalName(),'public');
            //         ParentAttachment::create([
            //              'file_path' => $file_path ,
            //              'parent_id' => MyParent::latest()->first()->id
            //         ]);
            //     }
            //   }

            session()->flash('success',trans('messages.edited'));
        }

        return redirect()->to('/add-parent');
    }

    public function delete($id){

        MyParent::findOrFail($id)->delete();
        session()->flash('success',trans('messages.deleted'));
        return redirect()->to('/add-parent');
    }


    //clear Form --------------------------------
    public function clearForm()
    {
        $this->email            = '';
        $this->password         = '';
        $this->father_name      = '';
        $this->father_job       = '';
        $this->father_job_en    = '';
        $this->father_name_en   = '';
        $this->father_passport  = '';
        $this->father_phone     = '';
        $this->father_identity     = '';
        $this->father_nationality_id ='';
        $this->father_blood_type_id  = '';
        $this->father_religion_id    = '';
        $this->father_address        = '';

        $this->mother_name           = '';
        $this->mother_job            = '';
        $this->mother_job_en         = '';
        $this->mother_name_en        = '';
        $this->mother_passport       = '';
        $this->mother_phone          = '';
        $this->mother_nationality_id = '';
        $this->mother_blood_type_id  = '';
        $this->mother_religion_id    = '';
        $this->mother_address        = '';

    }


    //back
    public function back($step)
    {
        $this->currentStep = $step;
    }

}
