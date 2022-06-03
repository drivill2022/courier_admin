<?php

use Illuminate\Database\Seeder;
use App\models\Notification;

class NotificationTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
	    	Notification::insert(array(
        	array(
				'message' => "সম্মানিত গ্রাহক, 
				  আপনার {{tracking_number}} পন্যটি ডেলিভারির জন্য  “ড্রাইভিল” ডেলিভারি সুপার হিরো {{rider_name}} নিয়ে বের হয়েছে। ডেলিভারি আপডেট পেতে এই লিংকে ক্লিক করুন। জরুরী প্রয়োজনে ফোন করুন ০৯৬১৭-১০২০৩০",
        	),
        	array(
				'message' => "সম্মানিত মার্চেন্ট। 
				আপনার {{tracking_number}} পন্যটি ডেলিভারির জন্য “ড্রাইভিল” ডেলিভারি সুপার হিরো {{rider_name}} নিয়ে বের হয়েছে। আপডেট পেতে আ্যপে চোখ রাখুন।",
        	),
            array(
                'message' => "সম্মানিত মার্চেন্ট। 
                  আপনার {{tracking_number}} পন্যটি সফলভাবে ডেলিভারি সম্পন্ন হয়েছে। মোট সিওডি {{cod_amount}} সংগ্রহ করা হয়েছে। আমাদের সেবা ভালো লেগে থাকলে, আমাদের ফেসবুক পেইজে অবশ্যই একটি রিভিও দিবেন। ",
            )
            ,
            array(
                'message' => "সম্মানিত মার্চেন্ট। 
                আপনার {{tracking_number}} পন্যটি গ্রাহক নিতে ইচ্ছুক নন। পন্যটি আগামী ২ দিনের মধ্যে আপনাকে  রিটার্ন করা হবে। রিটার্ন ফি ৫০% চার্জ করা হবে। ধন্যবাদ। ",
            ) 
        ));
    }
}
