// Je démare mon module
let app = {

    // Créer un objet vide pour ranger tous les element HTML qu'on va utiliser
    elements: {
        name: null,
        description: null,
        picture: null,
        price: null,
        subtitle: null,
        email: null,
        firstname: null,
        lastname: null,
        password: null,
        errorMessage: null

    },
  
    // Initialise le vericateur
    init: function() {

      // Je récupere tous les element html que je vais utilisé avec leurs id
      app.elements.name = document.querySelector('#name');
      app.elements.description = document.querySelector('#description');
      app.elements.picture = document.querySelector('#picture');
      app.elements.price = document.querySelector('#price');
      app.elements.subtitle = document.querySelector('#subtitle');
      app.elements.email = document.querySelector('#email');
      app.elements.firstname = document.querySelector('#firstname');
      app.elements.lastname = document.querySelector('#lastname');
      app.elements.password = document.querySelector('#password');
      // Je créer un element div qui contiendras mes message d'erreur
      app.elements.errorMessage = document.createElement("div");

      // Je verifie que l'element existe dans le formulaire que je visionne
      // si c'est le cas j'installe un ecouteur d'evenement sur l'event blur pour le champs selectionné
      if(app.elements.name != null) {
        app.elements.name.addEventListener('keyup', app.handleKeyupName);
      }
      if(app.elements.description != null) {
        app.elements.description.addEventListener('keyup', app.handleKeyupDescription);
      }
      if(app.elements.picture != null) {
        app.elements.picture.addEventListener('keyup', app.handleKeyupPicture);
      }
      if(app.elements.price != null) {
        app.elements.price.addEventListener('keyup', app.handleKeyupPrice);
      }
      if(app.elements.subtitle != null) {
        app.elements.subtitle.addEventListener('keyup', app.handleKeyupSubtitle);
      }
      if(app.elements.email != null) {
        app.elements.email.addEventListener('keyup', app.handleKeyupEmail);
      }
      if(app.elements.firstname != null) {
        app.elements.firstname.addEventListener('keyup', app.handleKeyupFirstname);
      }
      if(app.elements.lastname != null) {
        app.elements.lastname.addEventListener('keyup', app.handleKeyupLastname);
      }
      if(app.elements.password != null) {
        app.elements.password.addEventListener('keyup', app.handleKeyupPassword);
      }
      
    },
  
    // Fonctionne pour le champ name
    handleKeyupName: function() {
      
        // Je recup la valeur dans une variable
        let value = app.elements.name.value;

        // Je verifie si la longueur est supérieur a 3
        if(value.length < 3) {
            // Si ce n'est pas le cas j'enlève la class is-valid de l'element
            app.elements.name.classList.remove('is-valid');
            // Et je rajoute la classe is-invalid
            app.elements.name.classList.add('is-invalid');
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('Le nom doit contenir 3 caractères minimum');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.name.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
            // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            // J'enleve la classe is-invalid a mon champs
            app.elements.name.classList.remove('is-invalid'); 
            // Pour y rajouter la class is-valid
            app.elements.name.classList.add('is-valid');  
        }

    },

    handleKeyupDescription: function() {
      
        let value = app.elements.description.value;
        console.log(value.length);

        if(value.length <= 0) {
            app.elements.description.classList.remove('is-valid');
            app.elements.description.classList.add('is-invalid');  
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('La déscription ne doit pas être vide');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.description.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
             // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            app.elements.description.classList.remove('is-invalid'); 
            app.elements.description.classList.add('is-valid');  
        }

    },

    handleKeyupPicture: function() {
      
        let value = app.elements.picture.value;
        

        let http = value.indexOf("http://");
        let https = value.indexOf("https://");

        if(http === -1 && https === -1) {
            app.elements.picture.classList.remove('is-valid');
            app.elements.picture.classList.add('is-invalid'); 
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('Ce n\'est pas une url valide');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.picture.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
            // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            app.elements.picture.classList.remove('is-invalid'); 
            app.elements.picture.classList.add('is-valid');  
        }

    },
    handleKeyupPrice: function() {
      
        let value = app.elements.price.value;
        let priceParse = parseFloat(value);

        console.log(Number.isInteger(priceParse));
        if(!Number.isInteger(priceParse)) {
            app.elements.price.classList.remove('is-valid');
            app.elements.price.classList.add('is-invalid');  
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('Le prix doit être un nombre');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.price.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
            // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            app.elements.price.classList.remove('is-invalid'); 
            app.elements.price.classList.add('is-valid');  
        }

    },
    handleKeyupSubtitle: function() {
      
        let value = app.elements.subtitle.value;
        console.log(value.length);

        if(value.length < 5) {
            app.elements.subtitle.classList.remove('is-valid');
            app.elements.subtitle.classList.add('is-invalid');
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('Le sous-titre doit faire 5 caractères minimum');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.subtitle.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
            // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            app.elements.subtitle.classList.remove('is-invalid'); 
            app.elements.subtitle.classList.add('is-valid');  
        }

    },
    handleKeyupEmail: function() {
      
        let regex = new RegExp('[a-zA-Z0-9._-]+@[a-z0-9._-]{2,}[.]{1}[a-z]{2,4}');
        // Je recup la valeur dans une variable
        let value = regex.test(app.elements.email.value);

        // Je verifie si la longueur est supérieur a 3
        if(value == false) {
            // Si ce n'est pas le cas j'enlève la class is-valid de l'element
            app.elements.email.classList.remove('is-valid');
            // Et je rajoute la classe is-invalid
            app.elements.email.classList.add('is-invalid');
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('Ce n \'est pas un email valide : etudiant@oclock.io');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.email.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
            // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            // J'enleve la classe is-invalid a mon champs
            app.elements.email.classList.remove('is-invalid'); 
            // Pour y rajouter la class is-valid
            app.elements.email.classList.add('is-valid');  
        }

    },
    handleKeyupFirstname: function() {
      
        // Je recup la valeur dans une variable
        let value = app.elements.firstname.value;

        // Je verifie si la longueur est supérieur a 3
        if(value.length <= 0) {
            // Si ce n'est pas le cas j'enlève la class is-valid de l'element
            app.elements.firstname.classList.remove('is-valid');
            // Et je rajoute la classe is-invalid
            app.elements.firstname.classList.add('is-invalid');
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('Le prénom ne peux pas être vide');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.firstname.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
            // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            // J'enleve la classe is-invalid a mon champs
            app.elements.firstname.classList.remove('is-invalid'); 
            // Pour y rajouter la class is-valid
            app.elements.firstname.classList.add('is-valid');  
        }

    },
    handleKeyupLastname: function() {
      
        // Je recup la valeur dans une variable
        let value = app.elements.lastname.value;

        // Je verifie si la longueur est supérieur a 3
        if(value.length <= 0) {
            // Si ce n'est pas le cas j'enlève la class is-valid de l'element
            app.elements.lastname.classList.remove('is-valid');
            // Et je rajoute la classe is-invalid
            app.elements.lastname.classList.add('is-invalid');
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('Le nom ne peux pas être vide');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.lastname.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
            // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            // J'enleve la classe is-invalid a mon champs
            app.elements.lastname.classList.remove('is-invalid'); 
            // Pour y rajouter la class is-valid
            app.elements.lastname.classList.add('is-valid');  
        }

    },

    handleKeyupPassword: function() {
      
        let regex = new RegExp('(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\&\~\#\-\|\_\@\°\$\£\^\%\*\?\;\/\!\§]).{8,}');
        // Je recup la valeur dans une variable
        let value = regex.test(app.elements.password.value);


        // Je verifie si la longueur est supérieur a 3
        if(value == false) {
            // Si ce n'est pas le cas j'enlève la class is-valid de l'element
            app.elements.password.classList.remove('is-valid');
            // Et je rajoute la classe is-invalid
            app.elements.password.classList.add('is-invalid');
            // J'ajout la classe invalid-feedback a ma div d'erreur
            app.elements.errorMessage.classList.add('invalid-feedback');
            // J'ajout le texte de l'erreur a la div
            let content = document.createTextNode('Le mot de passe doit contenir Au moins 8 caractères, dont moins une majuscule, une minuscule, un chiffre et un caractère spécial');
            // Je verifie si la div n'a pas déjà du contenue a l'interieur
            if(app.elements.errorMessage.childNodes.length == 0) {
                // Si elle n'en a pas j'ajoute le texte de mon erreur
                app.elements.errorMessage.appendChild(content);
            }
            /// Et j'ajoute ma div directement après mon champs
            app.elements.password.insertAdjacentElement('afterend',app.elements.errorMessage);
            // par contre si la verification est bonne
        } else {
            // J'enlève la div d'erreur
            app.elements.errorMessage.remove();
            // J'enleve la classe is-invalid a mon champs
            app.elements.password.classList.remove('is-invalid'); 
            // Pour y rajouter la class is-valid
            app.elements.password.classList.add('is-valid');  
        }

    }


  };
  
  document.addEventListener('DOMContentLoaded', app.init);
   