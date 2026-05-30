<aside class="sidebar-panel" id="sidebar-2">
      <div class="sidebar-content">
        <header class="sidebar-header">
          <a href="#" class="menu-btn menu-btn-lg">
            <div
              class="flex items-center justify-center size-6 rounded-sm bg-primary text-primary-foreground text-sm font-bold shrink-0"
            >
              FD
            </div>
            First Decision Teste
          </a>
        </header>
        <nav class="sidebar-menu">
          <div class="menu-group">
            <span class="menu-label">Menu</span>
            <a href="#" class="menu-btn active">Dashboard</a>
            <a href="#" class="menu-btn active">Produtos</a>
          </div>
          
        </nav>
        <footer class="sidebar-footer">
            <div class="flex text-left text-sm leading-tight gap-2">
                    <img
                      src="https://placehold.co/32x32"
                      alt="Sarah Johnson"
                      class="size-8 rounded-lg"
                    />
                    <div class="flex flex-col">
                      <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                      <span class="truncate text-xs text-muted-foreground">
                        {{ auth()->user()->email }}
                      </span>
                    </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                  class="w-full btn btn-destructive"
                  data-sp-toggle="dropdown"
                  data-sp-target="#user-menu-2"
                  data-sp-placement="right-end"
                  aria-expanded="false"
                >
                Sair
              </button>
            </form>
        </footer>
      </div>
    </aside>