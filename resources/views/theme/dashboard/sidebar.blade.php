<ul class="toggled  navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
      <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-gas-pump"></i>
      </div>
      <div class="sidebar-brand-text mx-3">SIRMAT</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
      <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Tablero</span>
      </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
      Menú
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
          aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-book-open fa-2x"></i>
          <span>Solicitudes</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              <h6 class="collapse-header">Solicitudes:</h6>
              {{-- <a class="collapse-item" href="{{ route('solicitd.validacion_presupuestal.index') }}">
                <i class="fas fa-plus-circle"></i> Agregar
              </a> --}}
              @can('ver comision')
                <a href="{{ route('pre.comision.index') }}" rel="noopener noreferrer" class="collapse-item">
                  <i class="fas fa-keyboard"></i> Pre - Bitácora de Recorrido
                </a>
              @endcan


              @can('indice bitacora recorrido')
                <a class="collapse-item" href="{{ route('solicitud.bitacora.previo.guardado') }}">
                    <i class="fas fa-map-marked-alt"></i> Bitácora de Recorrido
                </a>
              @endcan
                {{-- <a class="collapse-item" href="{{ route('solicitud.bitacora.comision.index') }}">
                  <i class="fas fa-file-invoice"></i> Bitácora de Comisión
                </a> --}}

              @can('revisar comision')
                <a href="{{ route('solicitud.pre.comision.revision') }}"  class="collapse-item">
                  <i class="fas fa-check-square"></i> Revisar Comisión
                </a>
              @endcan

             {{-- solo rol de capturista deberá ver este apartado --}}
              @role('capturista')
                <a class="collapse-item" href="{{ route('solicitud.bitacora.index') }}">
                    <i class="far fa-paper-plane"></i> Bitácoras Enviadas
                </a>
              @endrole
             {{-- solo rol de capturista deberá ver este apartado END --}}
              @can('revisar bitacora')
                <a href="{{ route('solicitud.bitacora.revision') }}" class="collapse-item">
                    <i class="fas fa-eye"></i> Revisión de la Bitácora
                </a>
              @endcan
              <a href="{{ route('solicitud.bitacora.generar_documento.firma') }}" class="collapse-item">
                <i class="fas fa-file-signature"></i>
                Firma de la Bitácora
              </a>
          </div>
      </div>
  </li>

  <!-- Nav Item - Utilities Collapse Menu -->
    @can('ver catalogos')
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Catálogos</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Sección de Catálogos:</h6>
                @can('leer catalogo vehiculo')
                  <a href="{{ route('solicitud.cat.indice') }}" class="collapse-item">
                    <i class="fas fa-car"></i>
                    Catálogo de Vehiculos
                  </a>
                @endcan

                @can('leer catalogo choferes')
                  <a class="collapse-item" href="{{ route('solicitud.cat.chofer') }}">
                    <i class="fas fa-address-card"></i>
                    Catálogo Choferes
                  </a>
                @endcan

                @can('leer catalogo resguardante')
                  <a class="collapse-item" href="{{ route('solicitud.resguardante.indice') }}">
                    <i class="fas fa-user-shield"></i>
                    Resguardantes
                  </a>
                @endcan

               @can('leer catalogo vehiculo')
                  <a class="collapse-item" href="{{ route('solicitud.cat.directorio.indice') }}">
                    {{-- checar el cambio de permiso --}}
                    <i class="fas fa-sitemap"></i>
                    Directorio
                  </a>
               @endcan
            </div>
        </div>
      </li>
    @endcan

  {{-- Nav Item - Requisiciones --}}
  <li class="nav-item">
    <a class="nav-link" href="{{ route('requisicion.index') }}">
      <i class="fas fa-boxes fa-2x"></i>
      <span>Requisición</span>
    </a>
  </li>
  {{-- Nav Item - Requisiciones END --}}

  {{-- Nav Item - Revisión Requisiciones MODIFICACIONES EN SISTEMA 2023--}}
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRequisicionesRevision"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-clipboard"></i>
            <span>Revisión de Requisiciones</span>
    </a>
    <div id="collapseRequisicionesRevision" class="collapse" aria-labelledby="headingUtilities"
      data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Revisión:</h6>

        <a class="collapse-item" href="{{ route('requisicion.revision.index') }}">
          <i class="fas fa-search"></i>
          <span>Revisión de Requisiciones</span>
        </a>
        {{-- comment --}}
        <a class="collapse-item" href="{{ route('requisiciones.revision.existencia') }}">
          <i class="fas fa-clipboard-check"></i>
          Existencias
        </a>
      </div>
    </div>
  </li>
  {{-- Nav Item - Revisión Requisiciones END --}}


  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

  <!-- Sidebar Message -->
  <div class="sidebar-card d-none d-lg-flex">
      <img class="sidebar-card-illustration mb-2" src="{{ asset('assets/img/images/credencial.png') }}" alt="ICATECH">
  </div>

</ul>
