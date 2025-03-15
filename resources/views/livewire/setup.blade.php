 <div>
   <style>
     section {
       display: flex;
       justify-content: center;
       align-items: center;
     }

     .form-box {
       position: relative;
       width: 500px;
       height: 450px;
       background: transparent;
       border-left: 2px solid rgba(12, 200, 2, 0.5);
       border-right: 2px solid rgba(21, 212, 3, 0.5);
       border-radius: 20px;
       backdrop-filter: blur(15px);
       display: flex;
       justify-content: center;
       align-items: center;
     }

     .inputbox {
       position: relative;
       margin: 30px 0;
       width: 310px;
       border-bottom: 2px solid #fff;
     }

     .inputbox label {
       position: absolute;
       top: 50%;
       left: 5px;
       transform: translateY(-50%);
       color: #fff;
       font-size: 1em;
       transition: .5s;
     }

     input:focus~label,
     input:valid~label {
       top: -5px;
     }

     .inputbox input {
       width: 100%;
       height: 50px;
       background: transparent;
       border: none;
       outline: none;
       font-size: 1em;
       padding: 0 35px 0 5px;
       color: #fff;
     }

     .inputbox ion-icon {
       position: absolute;
       right: 8px;
       color: #fff;
       font-size: 1.2em;
       top: 20px;
     }

     .forget {
       margin: -15px 0 15px;
       font-size: .9em;
       color: #fff;
       display: flex;
       justify-content: center;
     }

     .forget label input {
       margin-right: 3px;
     }

     .forget label a {
       color: #fff;
       text-decoration: none;
       font-weight: 600
     }

     .forget label a:hover {
       text-decoration: underline;
     }

     button {
       width: 100%;
       height: 40px;
       border-radius: 40px;
       background: #fff;
       border: none;
       outline: none;
       cursor: pointer;
       font-size: 1em;
       font-weight: 600;
     }

     .register {
       font-size: .9em;
       color: #fff;
       text-align: center;
       margin: 25px 0 10px;
     }

     .register p a {
       text-decoration: none;
       color: #fff;
       font-weight: 600;
     }

     .register p a:hover {
       text-decoration: underline;
     }
   </style>
   @if ($school)
     <style>
       .card-container {
         width: 95%;
         height: 80%;
         margin: 10px;
         background: linear-gradient(to top right,
             #975af4,
             #2f7cf8 40%,
             #78aafa 65%,
             #934cff 100%);
         padding: 4px;
         border-radius: 32px;
         display: flex;
         flex-direction: column;
       }

       .card-container:hover {
         width: 100%;
         border: 3px solid rgb(4, 255, 4)
       }

       .card-container .title-card {
         display: flex;
         align-items: center;
         padding: 16px 18px;
         justify-content: space-between;
         color: #fff;
       }

       .card-container .title-card p {
         font-size: 14px;
         font-weight: 600;
         font-style: italic;
         text-shadow: 2px 2px 6px #2975ee;
       }

       .card-container .card-content {
         width: 100%;
         height: 100%;
         background-color: #161a20;
         border-radius: 30px;
         color: #838383;
         font-size: 12px;
         padding: 18px;
         display: flex;
         flex-direction: column;
         gap: 14px;
       }

       .card-container .card-content .title {
         font-weight: 600;
         color: #bab9b9;
       }

       .card-container .card-content .plain :nth-child(1) {
         font-size: 36px;
         color: #fff;
       }

       .card-container .card-content .card-btn {
         background: linear-gradient(4deg,
             #975af4,
             #2f7cf8 40%,
             #78aafa 65%,
             #934cff 100%);
         padding: 8px;
         border: none;
         width: 100%;
         border-radius: 8px;
         color: white;
         font-size: 12px;
         transition: all 0.3s ease-in-out;
         cursor: pointer;
         box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.6);
       }

       .card-container .card-content .card-btn:hover {
         color: #ffffff;
         text-shadow: 0 0 8px #fff;
         transform: scale(1.03);
       }

       .card-container .card-content .card-btn:active {
         transform: scale(1);
       }
     </style>

     <h1 class="text-bold text-center text-white">Get your License</h1>
     <form class="d-flex" style="justify-content: center; margin-top: 10px;" action="{{ route('buy_license') }}"
       method="POST">
       @csrf
       <div class="card-container">
         <div class="title-card">
           <p>SILVER</p>
           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
             <path fill="currentColor"
               d="M10.277 16.515c.005-.11.187-.154.24-.058c.254.45.686 1.111 1.177 1.412c.49.3 1.275.386 1.791.408c.11.005.154.186.058.24c-.45.254-1.111.686-1.412 1.176s-.386 1.276-.408 1.792c-.005.11-.187.153-.24.057c-.254-.45-.686-1.11-1.176-1.411s-1.276-.386-1.792-.408c-.11-.005-.153-.187-.057-.24c.45-.254 1.11-.686 1.411-1.177c.301-.49.386-1.276.408-1.791m8.215-1c-.008-.11-.2-.156-.257-.062c-.172.283-.421.623-.697.793s-.693.236-1.023.262c-.11.008-.155.2-.062.257c.283.172.624.42.793.697s.237.693.262 1.023c.009.11.2.155.258.061c.172-.282.42-.623.697-.792s.692-.237 1.022-.262c.11-.009.156-.2.062-.258c-.283-.172-.624-.42-.793-.697s-.236-.692-.262-1.022M14.704 4.002l-.242-.306c-.937-1.183-1.405-1.775-1.95-1.688c-.545.088-.806.796-1.327 2.213l-.134.366c-.149.403-.223.604-.364.752c-.143.148-.336.225-.724.38l-.353.141l-.248.1c-1.2.48-1.804.753-1.881 1.283c-.082.565.49 1.049 1.634 2.016l.296.25c.325.275.488.413.58.6c.094.187.107.403.134.835l.024.393c.093 1.52.14 2.28.634 2.542s1.108-.147 2.336-.966l.318-.212c.35-.233.524-.35.723-.381c.2-.032.402.024.806.136l.368.102c1.422.394 2.133.591 2.52.188c.388-.403.196-1.14-.19-2.613l-.099-.381c-.11-.419-.164-.628-.134-.835s.142-.389.365-.752l.203-.33c.786-1.276 1.179-1.914.924-2.426c-.254-.51-.987-.557-2.454-.648l-.379-.024c-.417-.026-.625-.039-.806-.135c-.18-.096-.314-.264-.58-.6m-5.869 9.324C6.698 14.37 4.919 16.024 4.248 18c-.752-4.707.292-7.747 1.965-9.637c.144.295.332.539.5.73c.35.396.852.82 1.362 1.251l.367.31l.17.145c.005.064.01.14.015.237l.03.485c.04.655.08 1.294.178 1.805">
             </path>
           </svg>
         </div>
         <div class="card-content">
           <p class="title">SILVER</p>
           <p class="plain">
             <span>&#8358;50,000</span>
             <span>/ year</span>
           </p>
           <p class="description">Best for School</p>
           <p class="description"><strike>Support for Multiple Schools/Institutions</strike></p>
           <p class="description"><strike>API Support</strike></p>
           <button class="card-btn" name="license" type="submit" value="Silver">Sign for Silver</button>
         </div>
       </div>
       <div class="card-container">
         <div class="title-card">
           <p>GOLD</p>
           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
             <path fill="currentColor"
               d="M10.277 16.515c.005-.11.187-.154.24-.058c.254.45.686 1.111 1.177 1.412c.49.3 1.275.386 1.791.408c.11.005.154.186.058.24c-.45.254-1.111.686-1.412 1.176s-.386 1.276-.408 1.792c-.005.11-.187.153-.24.057c-.254-.45-.686-1.11-1.176-1.411s-1.276-.386-1.792-.408c-.11-.005-.153-.187-.057-.24c.45-.254 1.11-.686 1.411-1.177c.301-.49.386-1.276.408-1.791m8.215-1c-.008-.11-.2-.156-.257-.062c-.172.283-.421.623-.697.793s-.693.236-1.023.262c-.11.008-.155.2-.062.257c.283.172.624.42.793.697s.237.693.262 1.023c.009.11.2.155.258.061c.172-.282.42-.623.697-.792s.692-.237 1.022-.262c.11-.009.156-.2.062-.258c-.283-.172-.624-.42-.793-.697s-.236-.692-.262-1.022M14.704 4.002l-.242-.306c-.937-1.183-1.405-1.775-1.95-1.688c-.545.088-.806.796-1.327 2.213l-.134.366c-.149.403-.223.604-.364.752c-.143.148-.336.225-.724.38l-.353.141l-.248.1c-1.2.48-1.804.753-1.881 1.283c-.082.565.49 1.049 1.634 2.016l.296.25c.325.275.488.413.58.6c.094.187.107.403.134.835l.024.393c.093 1.52.14 2.28.634 2.542s1.108-.147 2.336-.966l.318-.212c.35-.233.524-.35.723-.381c.2-.032.402.024.806.136l.368.102c1.422.394 2.133.591 2.52.188c.388-.403.196-1.14-.19-2.613l-.099-.381c-.11-.419-.164-.628-.134-.835s.142-.389.365-.752l.203-.33c.786-1.276 1.179-1.914.924-2.426c-.254-.51-.987-.557-2.454-.648l-.379-.024c-.417-.026-.625-.039-.806-.135c-.18-.096-.314-.264-.58-.6m-5.869 9.324C6.698 14.37 4.919 16.024 4.248 18c-.752-4.707.292-7.747 1.965-9.637c.144.295.332.539.5.73c.35.396.852.82 1.362 1.251l.367.31l.17.145c.005.064.01.14.015.237l.03.485c.04.655.08 1.294.178 1.805">
             </path>
           </svg>
         </div>
         <div class="card-content">
           <p class="title">GOLD</p>
           <p class="plain">
             <span>&#8358;69,000</span>
             <span>/ year</span>
           </p>
           <p class="description">Best for large School or Institution</p>
           <p class="description">Support for Multiple Schools/Institutions</p>
           <p class="description"><strike>API Support</strike></p>
           <button class="card-btn" name="license" type="submit" value="gold">Sign for Gold</button>
         </div>
       </div>
       <div class="card-container">
         <div class="title-card">
           <p>DIAMOND</p>
           <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
             <path fill="currentColor"
               d="M10.277 16.515c.005-.11.187-.154.24-.058c.254.45.686 1.111 1.177 1.412c.49.3 1.275.386 1.791.408c.11.005.154.186.058.24c-.45.254-1.111.686-1.412 1.176s-.386 1.276-.408 1.792c-.005.11-.187.153-.24.057c-.254-.45-.686-1.11-1.176-1.411s-1.276-.386-1.792-.408c-.11-.005-.153-.187-.057-.24c.45-.254 1.11-.686 1.411-1.177c.301-.49.386-1.276.408-1.791m8.215-1c-.008-.11-.2-.156-.257-.062c-.172.283-.421.623-.697.793s-.693.236-1.023.262c-.11.008-.155.2-.062.257c.283.172.624.42.793.697s.237.693.262 1.023c.009.11.2.155.258.061c.172-.282.42-.623.697-.792s.692-.237 1.022-.262c.11-.009.156-.2.062-.258c-.283-.172-.624-.42-.793-.697s-.236-.692-.262-1.022M14.704 4.002l-.242-.306c-.937-1.183-1.405-1.775-1.95-1.688c-.545.088-.806.796-1.327 2.213l-.134.366c-.149.403-.223.604-.364.752c-.143.148-.336.225-.724.38l-.353.141l-.248.1c-1.2.48-1.804.753-1.881 1.283c-.082.565.49 1.049 1.634 2.016l.296.25c.325.275.488.413.58.6c.094.187.107.403.134.835l.024.393c.093 1.52.14 2.28.634 2.542s1.108-.147 2.336-.966l.318-.212c.35-.233.524-.35.723-.381c.2-.032.402.024.806.136l.368.102c1.422.394 2.133.591 2.52.188c.388-.403.196-1.14-.19-2.613l-.099-.381c-.11-.419-.164-.628-.134-.835s.142-.389.365-.752l.203-.33c.786-1.276 1.179-1.914.924-2.426c-.254-.51-.987-.557-2.454-.648l-.379-.024c-.417-.026-.625-.039-.806-.135c-.18-.096-.314-.264-.58-.6m-5.869 9.324C6.698 14.37 4.919 16.024 4.248 18c-.752-4.707.292-7.747 1.965-9.637c.144.295.332.539.5.73c.35.396.852.82 1.362 1.251l.367.31l.17.145c.005.064.01.14.015.237l.03.485c.04.655.08 1.294.178 1.805">
             </path>
           </svg>
         </div>
         <div class="card-content">
           <p class="title">DIAMOND</p>
           <p class="plain">
             <span>&#8358;98,000</span>
             <span>/ year</span>
           </p>
           <p class="description">Best for CBT centers</p>
           <p class="description">Support for Multiple Schools/Institutions</p>
           <p class="description">API Support</p>
           <button class="card-btn" name="license" type="submit" value="diamond">Sign for Diamond</button>
         </div>
       </div>

     </form>
   @else
     <section>
       <div class="form-box">
         <form wire:submit='save'>
           <div class="inputbox relative mb-3 w-full">
             <input id="school_name" name="school_name" type="text" required autofocus
               wire:model.live='school_name' />
             <label class="mb-2 block text-xs font-bold uppercase" for="school_name">
               SCHOOL NAME
             </label>
             @error('school_name')
               <div class="text-red-500">
                 <small>{{ $message }}</small>
               </div>
             @enderror
           </div>

           <div class="inputbox relative mb-3 w-full">
             <input id="school_email" name="school_email" type="email" required autofocus
               wire:model.live='school_email' />
             <label class="mb-2 block text-xs font-bold uppercase" for="school_email">
               SCHOOL EMAIL
             </label>
             @error('school_email')
               <div class="text-red-500">
                 <small>{{ $message }}</small>
               </div>
             @enderror
           </div>

           <div class="form-group relative mb-3 w-full">
             <label class="mb-2 block text-xs font-bold uppercase text-white" for="school_type">
               SCHOOL Type
             </label>
             <select class="form-control" id="school_type" name="school_type">
               <option value="School">School</option>
               <option value="Institution">Institution</option>
               <option value="Others">Others</option>
             </select>
             @error('school_type')
               <div class="text-red-500">
                 <small>{{ $message }}</small>
               </div>
             @enderror
           </div>

           <div class="d-grid mt-4 gap-2" style="margin-top: 15px;">
             <button class="btn btn-success" type="submit" style="background-color: rgb(3, 250, 3)">Set my
               school</button>
           </div>
         </form>
       </div>
     </section>
   @endif
 </div>
