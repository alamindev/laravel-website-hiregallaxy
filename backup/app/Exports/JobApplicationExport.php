<?php



namespace App\Exports;



use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;



class JobApplicationExport implements FromArray, WithHeadings, ShouldAutoSize

{

    protected $job;

    protected $applications;


    public function __construct($job, array $applications)

    {

        $this->job = $job;

        $this->applications = $applications;

    }



    public function array(): array

    {

    	$data = [];
        
    	foreach ($this->applications as $apply) {

    		$data[] = [

    			$apply->id,

    			$this->job->title,

    			$apply->user->name,

    			$apply->user->email,

    			$apply->user->phone_no,

    			$apply->created_at

    		];

    	}

        return $data;

    }



    public function headings(): array

    {

        return [

            'ID',

            'Job Title',

            'Name',

            'Email',

            'Mobile',

            'Applied at'

        ];

    }

}

