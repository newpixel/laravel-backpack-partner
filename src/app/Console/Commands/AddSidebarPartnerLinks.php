<?php

namespace Newpixel\PartnerCRUD\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AddSidebarPartnerLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pixeltour:add-sidebar-partner-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add links for partners CRUD to the Backpack sidebar_content file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = 'resources/views/vendor/backpack/base/inc/sidebar_content.blade.php';
        $disk_name = config('backpack.base.root_disk_name');
        $disk = Storage::disk($disk_name);
        $code = '
{{-- Partners tree links --}}
<li><a href="{{ backpack_url(\'partner\') }}"><i class="fa fa-briefcase"></i> <span>Parteneri</span></a></li>';

        if ($disk->exists($path)) {
            $contents = Storage::disk($disk_name)->get($path);

            if ($disk->put($path, $contents.PHP_EOL.$code)) {
                $this->info('Successfully added partners links tree to sidebar_content file.');
            } else {
                $this->error('Could not write to sidebar_content file.');
            }
        } else {
            $this->error("The sidebar_content file does not exist. Make sure Backpack\Base is properly installed.");
        }
    }
}
