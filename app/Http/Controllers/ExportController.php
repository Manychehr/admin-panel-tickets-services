<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExportRequest;
use App\Models\ApiTicket;
use App\Models\Author;
use App\Models\Comment;
use App\Models\Domain;
use App\Models\IpAddress;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\Website;
use App\Services\DomainExportService;
use App\Services\KayakoService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ExportController extends AuthBaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('export');
    }

    /**
     * Show Author autocomplete-ajax
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete_author(Request $request)
    {
        $authors = Author::select('id', DB::raw('name as text'))
                            ->orderBy('name','asc')
                            ->when(!empty($request->search), function ($query) use($request){
                                $query->where('name', 'like', '%' . $request->search . '%');
                            })
                            ->paginate(5);

        return response()->json([
            "results" => $authors->items(),
            "pagination" => [
                "more" => (bool)$authors->nextPageUrl()
            ]
        ]);
    }

    /**
     * Show Domain autocomplete-ajax
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete_domain(Request $request)
    {
        $domains = Domain::select('id', DB::raw('host as text'))
                            ->orderBy('host','asc')
                            ->when(!empty($request->search), function ($query) use($request){
                                $query->where('host', 'like', '%' . $request->search . '%');
                            })
                            ->groupBy(['host'])
                            ->paginate(5);

        return response()->json([
            "results" => $domains->items(),
            "pagination" => [
                "more" => (bool)$domains->nextPageUrl()
            ]
        ]);
    }

    /**
     * Show IpAddress autocomplete-ajax
     *
     * @return \Illuminate\Http\Response
     */
    public function autocomplete_ip(Request $request)
    {
        $ips = IpAddress::select('id', DB::raw('ip as text'))
                            ->orderBy('ip','asc')
                            ->when(!empty($request->search), function ($query) use($request){
                                $query->where('ip', 'like', '%' . $request->search . '%');
                            })
                            ->paginate(5);

        return response()->json([
            "results" => $ips->items(),
            "pagination" => [
                "more" => (bool)$ips->nextPageUrl()
            ]
        ]);
    }

    /**
     * export file the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export_file(StoreExportRequest $request)
    {
        $tickets = $this->get_export_ticket($request);

        $content = view('export_file', compact('tickets'))->render();
        // Set the name of the text file
        $filename = 'export.txt';
        // Set headers necessary to initiate a download of the textfile, with the specified name
        $headers = array(
            'Content-Type' => 'plain/txt',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            'Content-Length' => strlen($content),
        );
        
        return Response::make($content, 200, $headers);
    }

    public function get_export_ticket($request)
    {
        if ($request->input('select_all')) {
            return Ticket::all();
        }
        return Ticket::orderBy('created_at','asc')
                        ->when(!empty($request->input('start_parsing')) && !empty($request->input('end_parsing')), function ($query) use($request){
                            $query->whereBetween('created_at',  [$request->input('start_parsing'), $request->input('end_parsing')]);
                        })
                        ->when(!empty($request->input('user_name')), function ($query) use($request){
                            $query->whereHas('author', function ($query) use ($request) {
                                $query->where('name', $request->input('user_name'));
                            });
                        })
                        ->when(!empty($request->input('select_author')), function ($query) use($request){
                            $query->whereHas('author', function ($query) use ($request) {
                                $query->where('id', $request->input('select_author'));
                            });
                        })
                        ->when(!empty($request->input('select_domain')), function ($query) use($request){

                            $domain = Domain::findOrFail((int)$request->input('select_domain'));

                            $query->whereHas('domains', function ($query) use ($domain) {
                                $query->where('host', $domain->host);
                            });
                        })
                        ->when(!empty($request->input('select_ip')), function ($query) use($request){

                            $ip_address = IpAddress::findOrFail((int)$request->input('select_ip'));

                            $query->whereHas('ip_addresses', function ($query) use ($ip_address) {
                                $query->where('ip', $ip_address->ip);
                            });
                        })
                        ->get();
    }

    public function export_file_attachment(Comment $comment, $attachment_id)
    {
        if (empty($comment->get_attachment($attachment_id))) {
            return 'get_attachment faled';
        }
        
        if (empty($apiTicket = ApiTicket::find($comment->service_id)) && $apiTicket->service !== 'kayako') {
            return 'service faled';
        }

        $kayako = KayakoService::getApi($comment->service_id);
        /**
         * @var \App\KayakoApi\kyTicketAttachment $attachment
         */
        $attachment = $kayako->getAttachment($comment->ticket_id, $attachment_id);

        $headers = array(
            'Content-Type' => $attachment->getFileType(),
            'Content-Disposition' => sprintf('attachment; filename="%s"', $attachment->getFileName()),
            'Content-Length' => $attachment->getFileSize()//strlen($content),
        );
        
        return Response::make($attachment->getContents(), 200, $headers);
    }
}
