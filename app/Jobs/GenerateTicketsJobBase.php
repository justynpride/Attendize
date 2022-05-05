<?php

namespace App\Jobs;

use App\Generators\TicketGenerator;
use App\Models\Attendee;
use App\Models\Order;
use App\Services\PDFGenerator\PDFFile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateTicket extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels, Dispatchable;

    /**
     * @var Order $order
     */
    public $order;

    /**
     * @var Attendee $attendee
     */
    public $attendee;

    /**
     * @var PDFFile $pdf_file
     */
    public $pdf_file;

    /**
     * Create a new job instance.
     *
     * @param  Order  $order
     * @param  Attendee  $attendee
     */
    public function __construct(Order $order, Attendee $attendee = null)
    {
        $this->order = $order;
        $this->attendee = $attendee;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        $file_path = public_path(config('attendize.event_pdf_tickets_path')) . '/' . $this->file_name;
        $file_with_ext = $file_path . '.pdf';

        if (file_exists($file_with_ext)) {
            Log::info("Use ticket from cache: " . $file_with_ext);
            return;
        }

        $organiser = $this->event->organiser;
        $image_path = $organiser->full_logo_path;
        $images = [];
        $imgs = $this->event->images;
        foreach ($imgs as $img) {
            $event_image_abs_pathname = public_path($img->image_path);
            if (file_exists($event_image_abs_pathname)) {
                $images[] = base64_encode(file_get_contents($event_image_abs_pathname));
            } else {
                Log::warn(sprintf("Image doesn't exist: `%s`", $event_image_abs_pathname));
            }
        }

        $data = [
            'order'     => $this->order,
            'event'     => $this->event,
            'attendees' => $this->attendees,
            'css'       => file_get_contents(public_path('assets/stylesheet/ticket.css')),
            'image'     => base64_encode(file_get_contents(public_path($image_path))),
            'images'    => $images,
        ];
        try {
            PDF::setOutputMode('F'); // force to file
            PDF::html('Public.ViewEvent.Partials.PDFTicket', $data, $file_path);
            Log::info("Ticket generated!");
        } catch(\Exception $e) {
            Log::error("Error generating ticket. This can be due to permissions on vendor/nitmedia/wkhtml2pdf/src/Nitmedia/Wkhtml2pdf/lib. This folder requires write and execute permissions for the web user");
            Log::error("Error message. " . $e->getMessage());
            Log::error("Error stack trace" . $e->getTraceAsString());
            $this->fail($e);
        }
        $this->pdf_file = TicketGenerator::createPDFTicket($this->order, $this->attendee);
        $this->pdf_file->error ?: $this->fail();
    }
}
