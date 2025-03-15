 document.addEventListener('DOMContentLoaded', () => {
   const toggles = document.querySelectorAll('.themeToggle');
   const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');

   // Function to get the ion-content of tab3
   function getTab3Content() {
     const tab3 = document.querySelector('ion-tab[tab="tab3"]');
     return tab3 ? tab3.querySelector('ion-content') : null;
   }

   // Apply the stored theme on page load
   function loadApp() {
     const savedTheme = localStorage.getItem('theme');
     const isDark = savedTheme === 'dark' || (!savedTheme && prefersDark.matches);
     updateTheme(isDark);
   }

   // Update theme in local storage and ion-content color attribute
   function updateTheme(isDark) {
     document.body.classList.toggle('dark', isDark);

     // Change the color attribute of ion-content in tab3 based on the theme
     const content = getTab3Content();
     if (content) {
       content.setAttribute('color', isDark ? 'dark' : 'light');
     }

     localStorage.setItem('theme', isDark ? 'dark' : 'light');
     toggles.forEach(toggle => toggle.checked = isDark); // Synchronize all toggles
   }

   // Set event listeners for toggles
   toggles.forEach(toggle => {
     toggle.addEventListener('ionChange', (ev) => {
       const isDark = ev.detail.checked;
       updateTheme(isDark);
     });
   });

   // Update theme on system preference change
   prefersDark.addEventListener('change', (e) => {
     updateTheme(e.matches);
   });

   loadApp();

   // Configure action sheet (ensure there's only one instance or handle accordingly)
   const actionSheet = document.querySelector('ion-action-sheet');
   if (actionSheet) {
     actionSheet.buttons = [
       {
         text: 'Delete',
         role: 'destructive',
         data: { action: 'delete' },
      },
       {
         text: 'Share',
         data: { action: 'share' },
      },
       {
         text: 'Cancel',
         role: 'cancel',
         data: { action: 'cancel' },
      },
    ];
   }
 });
