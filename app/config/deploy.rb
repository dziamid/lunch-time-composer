set :application, "LunchTime"
set :domain,      "dream"
set :deploy_to,   "/var/www/dev"
set :app_path,    "app"
set :web_path,    "web"
set :repository,  "https://github.com/dziamid/lunch-time-composer.git"
set :scm,         :git
#set :deploy_via, :remote_cache
set :model_manager, "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Rails migrations will run

set  :keep_releases,  3
default_run_options[:pty] = true

# Be more verbose by uncommenting the following line
logger.level = Logger::MAX_LEVEL

set :shared_children, [web_path + "/uploads", "vendor"]
set :update_vendors, false
set :use_composer, true
set :vendors_mode, "install"
set :user, "dziamid"
set :use_sudo, false
