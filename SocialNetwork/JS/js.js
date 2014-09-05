
visibleAlert=false;
visibleInbox=false;
visibleOutbox=false;
visibleSuggestedFriends=false;
visibleSuggestedNeighbours=false;


function linka(event,page){ //utile per il funzionamento da tastiera
       if(event.keyCode==13){ //se il tasto premuto è "Invio""
          location.href='index.php?view='+page; //redirect sulla pagina passata come parametro
       }
}


function view(event,icon){

        if(event.keyCode==13 || event.type=='click'){ //se il tasto premuto � invio
            
            if(icon=='alert'){ //se viene chiamato dal tasto notifiche
                
                $( "#inbox_panel" ).slideUp(100); //tiro su gli altri 2 pannelli se fossero aperti
                $( "#outbox_panel" ).slideUp(100); 
                
                if(!visibleAlert) //se non � visibile si tira gi� il pannello
                    $( "#alert_panel" ).slideDown(200);
                else if(visibleAlert) //se � visibile si tira su
                    $( "#alert_panel" ).slideUp(500);  

                visibleAlert=!visibleAlert; //si inverte lo stato

                return false;
            }
            
            else if(icon=='inbox'){ //se viene chiamato dal tasto inbox
                
              $( "#alert_panel" ).slideUp(100); //tiro su gli altri 2 pannelli se fossero aperti
              $( "#outbox_panel" ).slideUp(100);

              if(!visibleInbox) //se non � visibile si tira gi� il pannello
                $( "#inbox_panel" ).slideDown(200);  
              else if(visibleInbox)//se � visibile si tira su
                $( "#inbox_panel" ).slideUp(500);  

              visibleInbox=!visibleInbox; //si inverte lo stato

              return false;
                
            }
            else if(icon=='outbox'){ //se viene chiamato dal tasto outbox
                
              $( "#inbox_panel" ).slideUp(100); //tiro su gli altri 2 pannelli se fossero aperti
              $( "#alert_panel" ).slideUp(100);

              if(!visibleOutbox) //se non � visibile si tira gi� il pannello
                $( "#outbox_panel" ).slideDown(200);  
              else if(visibleOutbox) //se � visibile si tira su
                $( "#outbox_panel" ).slideUp(500);  

              visibleOutbox=!visibleOutbox; //si inverte lo stato

              return false;
                
            }
            else if(icon=='suggested_friends'){ //se viene chiamato dal tasto laterale destro suggested_friends
                
                if(!visibleSuggestedFriends) //se non � visibile si tira gi� il pannello
                    $( "#right_menu_content_up" ).slideDown(1000);
                else if(visibleSuggestedFriends) //se � visibile si tira su
                    $( "#right_menu_content_up" ).slideUp(1000);

                visibleSuggestedFriends=!visibleSuggestedFriends; //si inverte lo stato
                return false;
                
            }
            
            else if(icon=='suggested_neighbor'){ //se viene chiamato dal tasto laterale destro suggested_neighbor
                
                if(!visibleSuggestedNeighbours) //se non � visibile si tira gi� il pannello
                                $( "#right_menu_content_down" ).slideDown(1000);
                            else if(visibleSuggestedNeighbours) //se � visibile si tira su
                                $( "#right_menu_content_down" ).slideUp(1000);

                            visibleSuggestedNeighbours=!visibleSuggestedNeighbours; //si inverte lo stato
                            return false;
                
            }
            
        }
       return false;
    }

function showResult(str) //prende la stringa che vogliamo cercare
{
if (str.length==0) //controlliamo che che la stringa sia nulla
  { 
  document.getElementById("livesearch").innerHTML=""; //in tal caso non stampa nulla
  document.getElementById("livesearch").style.border="0px";
  return;
  }
if (window.XMLHttpRequest) //codice per i seguenti browser se supporta l'XML http Request
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();  //crea un oggetto di tipo XML http Request
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function() //associamo al cambiamento di stato della richiesta una funzione (lo stato cambia su open e send())
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200) //quando la richiesta � finita e la risposta � pronta e lo stato � OK
    {
    document.getElementById("livesearch").innerHTML=xmlhttp.responseText; //stampiamo nel div livesearch il testo di risposta
    document.getElementById("livesearch").style.border="1px solid #A5ACB2"; // settiamo un border colorato
    }
  }
xmlhttp.open("GET","user_search_instant.php?q="+str,true); //apriamo la richiesta passando il metodo ed il file da utilizzare per effettuare la richiesta
xmlhttp.send(); //mandiamo la richiesta
}

function close_pane(element) {   

		switch(element){
		
		case 'alert': $( "#alert_panel" ).slideUp(500); break;
		case 'inbox': $( "#inbox_panel" ).slideUp(500); break;
		case 'outbox': $( "#outbox_panel" ).slideUp(500); break;
		case 'livesearch': 
				$( "#livesearch" ).slideUp(500);
				f=document.getElementById("search_form");
				f.q.value="Ricerca Utenti";				
				break;					       
		} 
}

function check_form(form){
        var name  = form.name; //mi salvo tutte le variabili provenienti dal form
        var surname  = form.surname;
	var birthplace  = form.birthplace;
	var email  = form.email;
	var password  = form.password;
	var confirm_password  = form.confirm_password;
	var error=false;
        
        //controllo che i campi obbligatori siano vuoti e se son vuoti inseriamo bordo rosso e settiamo error a true
	if(name.value==""){
	    name.setAttribute('class','h_lighted');
            error=true;
        }
        if(surname.value==""){
            surname.setAttribute('class','h_lighted');
            error=true;
        }
	if(birthplace.value==""){
            birthplace.setAttribute('class','h_lighted');
            error=true;
        }
	if(email.value==""){
            email.setAttribute('class','h_lighted');
            error=true;
        }
	if(password.value==""){
            password.setAttribute('class','h_lighted');
            error=true;
        }
	if(confirm_password.value==""){
            confirm_password.setAttribute('class','h_lighted');
            error=true;
        }
        
        if(password.value != confirm_password.value){ //controllo se le password sono uguali 
            password.setAttribute('class','h_lighted');
            confirm_password.setAttribute('class','h_lighted');
            error=true;
        }
        
        //se error è true ritorniamo false di modo che il form non venga inviato 
        if(error==true)return false;
	else{ //in caso contrario il form viene validato ed inviato
	   	form.submit();
                return true;
	} 
}

function alert_delete(form){
    
    answer=confirm("Sei sicuro di cancellare definitivamente dal sistema questo utente ?");
    if(answer==true){
        
        form.submit();                                   
        return true;
    }
    else return false;
    
}

function clear_search_user(form){     //setto il valore a vuoto del campo testo della ricerca utente quando il focus � dentro
	
    form.q.value="";
}
function set_search_user(form){     
    form.q.value="Ricerca Utenti";	//setto il valore del campo testo della ricerca utente quando il focus � fuori
}
function controllomail(mail){
	var espressione = /^[_a-z0-9+-]+(\.[_a-z0-9+-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$/; //setto l'espressione regolare di una mail
	
	return espressione.test(mail); //controllo se il valore inserito rispetta il formato di una mail
	
}

