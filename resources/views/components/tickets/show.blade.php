
<div class="block-header bg-primary-dark">
    <h3 class="block-title">Show Ticket #{{ $ticket->api_id }}</h3>
    <div class="block-options">
        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
            <i class="si si-close"></i>
        </button>
    </div>
</div>
<div class="block-content">
    <h3>{{ $ticket->data['subject'] }}</h3>
    <!-- ticket Info -->
    <div class="row my-20">
        <div class="col-sm-6">
            <address>
                Created: {{ $ticket->created_at->format('Y-m-d H:m') }}<br>
                Author: {{ $ticket->author->name }}<br>
                Author email: {{ $ticket->author->data['email']?? '' }}<br>
            </address>
        </div>
        <div class="col-sm-6 text-right">
            <address>
                Domains: {{ $ticket->domains_count() }}<br>
                Ip: {{ $ticket->ip_addresses_count() }}<br>
                Entries: {{ $ticket->in_scheme? 'yes' : 'no' }}<br>
            </address>
        </div>
    </div>
    <!-- ticket Info -->
    <div class="row text-center">
        <div class="col-sm-6">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Domain</h3>
                </div>
                <div class="block-content">
                    <ul class="nav nav-pills flex-column push">
                        @forelse ($ticket->domains_order_rank() as $item)
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between" href="javascript:void(0)" style="padding: .5rem 0;">
                                <span>{{ $item->host }}</span>
                                <span class="badge badge-pill badge-secondary">{{ $item->rank }}</span>
                            </a>
                        </li>
                        @empty
                        <li>no domains detected</li>
                        @endforelse
                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="block">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Ip Addresses</h3>
                </div>
                <div class="block-content">
                    <ul class="nav nav-pills flex-column push">
                        @forelse ($ticket->ip_addresses as $item)
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center justify-content-between" href="javascript:void(0)" style="padding: .5rem 0;">
                                <span>{{ $item->ip }}</span>
                            </a>
                        </li>
                        @empty
                        <li>no domains detected</li>
                        @endforelse
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
