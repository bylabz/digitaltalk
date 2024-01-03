<?php

namespace App\Services;

use App\DTOs\BookingController\StoreRequestDTO;
use DTApi\Repository\BookingRepository;

class BookingService
{
    protected BookingRepository $bookingRepository;

    public function __construct(BookingRepository $bookingRepository)
    {
        $this->bookingRepository = $bookingRepository;
    }

    /**
     * @param Users $user
     * @param StoreRequestDTO $DTO
     * @return array
     */
    public function store(Users $user, StoreRequestDTO $DTO): array
    {
        if ($user->user_type == env('CUSTOMER_ROLE_ID')) {
            throw new Exception("Translator can not create booking");
        }

        $this->bookingRepository->store($user, $DTO);
    }

    /**
     * @param Job $job
     * @param Users $user
     * @return array
     */
    public function acceptJob(Job $job, Users $user): array
    {
        $cuser = $user;
        if (!Job::isTranslatorAlreadyBooked($job->id, $cuser->id, $job->due)) {
            if ($job->status == 'pending' && Job::insertTranslatorJobRel($cuser->id, $job->id)) {
                $job->status = 'assigned';
                $job->save();
                $user = $job->user()->get()->first();
                $mailer = new AppMailer();

                if (!empty($job->user_email)) {
                    $email = $job->user_email;
                    $name = $user->name;
                    $subject = 'Bekräftelse - tolk har accepterat er bokning (bokning # ' . $job->id . ')';
                } else {
                    $email = $user->email;
                    $name = $user->name;
                    $subject = 'Bekräftelse - tolk har accepterat er bokning (bokning # ' . $job->id . ')';
                }
                $data = [
                    'user' => $user,
                    'job'  => $job
                ];
                $mailer->send($email, $name, $subject, 'emails.job-accepted', $data);

            }

            $jobs = $this->bookingRepository->getPotentialJobs($cuser);
            $response = array();
            $response['list'] = json_encode(['jobs' => $jobs, 'job' => $job], true);
            $response['status'] = 'success';
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Du har redan en bokning den tiden! Bokningen är inte accepterad.';
        }

        return $response;
    }

    /**
     * @param distanceFeedRequestDTO $DTO
     * @return void
     */
    public function distanceFeed(distanceFeedRequestDTO $DTO): void
    {
        if ($DTO->getTime() || $DTO->getDistance()) {
            Distance::where('job_id', '=', $DTO->getJobId())->update([
                'distance' => $DTO->getDistance(),
                'time'     => $DTO->getTime()
            ]);
        }

        if ($DTO->getAdminComment() || $DTO->getSession() || $DTO->getFlagged() || $DTO->getManuallyHandled() || $DTO->getByAdmin()) {
            Job::where('id', '=', $DTO->getJobId())->update([
                'admin_comments'   => $DTO->getAdminComment(),
                'flagged'          => $DTO->getFlagged(),
                'session_time'     => $DTO->getSession(),
                'manually_handled' => $DTO->getManuallyHandled(),
                'by_admin'         => $DTO->getByAdmin()
            ]);
        }
    }
}