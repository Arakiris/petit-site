window.createRankingArchives = function(lenghtlast, previousYear, url, url_storage) {
    let tabs = document.querySelectorAll('ul.tabs li');
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    if(previousYear !== null) {
        if(lenghtlast && lenghtlast > 5){
            $(function(){
                $('#table-' + previousYear).paginathing({
                    perPage: 5,
                    insertAfter: '#pag-' + previousYear,
                    prevText: '&lt;',
                    nextText: '&gt;',
                    firstText: '&laquo;',
                    lastText: '&raquo;'
                });
            });
        }

        for (let i = 0; i < tabs.length; i++){
            tabs[i].addEventListener('click', event => {
                let tab_id = event.target.getAttribute('data-tab');
                let parentToAddElement = document.getElementById(tab_id);
                let id = tab_id.substring(4);

                document.querySelector('li.tabs__link-current').classList.remove('tabs__link-current');
                document.querySelector('div.tabs__content-current').classList.remove('tabs__content-current');

                event.target.classList.add('tabs__link-current');
                parentToAddElement.classList.add('tabs__content-current');

                if(parentToAddElement.classList.contains('not-loaded')){
                    getDataRanking(id, token, parentToAddElement, url);
                    parentToAddElement.classList.remove('not-loaded');
                }
            }, false);
        }
    }

    function getDataRanking(id, token, parent, url) {
        renderLoader(parent);
        getDataAjax(url, id, token).then(podia => {
            renderRanking(podia, parent);

            if(podia.length > 5){
                $(function(){
                    $('#table-' + id).paginathing({
                        perPage: 5,
                        insertAfter: '#pag-' + id,
                        prevText: '&lt;',
                        nextText: '&gt;',
                        firstText: '&laquo;',
                        lastText: '&raquo;'
                    });
                });
            }

            clearLoader(parent);
        });
        
    }

    async function getDataAjax(url, id, token) {
        const response = await fetch(url, {
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token
                },
                method: 'post',
                credentials: "same-origin",
                body: JSON.stringify({
                    id: id
                })
            });
        const resData = await response.json();

        return resData
    }

    const renderLoader = parent => {
        const loader = `
            <div class="loader"></div>
        `;
        parent.insertAdjacentHTML("afterbegin", loader);
    };

    const clearLoader = parent => {
        let loader = parent.querySelector('.loader');
        if(loader)
            loader.parentElement.removeChild(loader);
    };

    const renderRanking = (podia, parent) => {
        let dateString = podia[0].date.substring(0, 10).split('-');

        let markup = `
            <div class="archives__tables archives__tables-ranking" id="table-${dateString[0]}"> 
        `;

        podia.forEach(el => {
            markup += renderLineRanking(el, parent);
        });
    
        markup += `
            </div>
        `;

        parent.insertAdjacentHTML("afterbegin", markup);

        let markup2 = `
            <div class="event__bottom bottom-tournament-league">
                <div class="pagination bottom-div" id="pag-${dateString[0]}">
                </div>
            </div>
        `;

        parent.insertAdjacentHTML("beforeend", markup2);
    }

    const renderLineRanking = (podium, parent) => {
        let dateString = podium.date.substring(0, 10).split('-');
        let date = new Date(dateString[0], dateString[1], dateString[2]);

        let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

        let dateFormat = date.toLocaleString('fr-FR', options);
        dateFormat = dateFormat.charAt(0).toUpperCase() + dateFormat.slice(1);

        let storage = url_storage;

        let markup = `
            <div class="archives__row archives__row-ranking">
                <div class="event__single-information occasion-information">
        `;

        // Render first column
        if( ((typeof podium.tournament.rules_url == "undefined" || podium.tournament.rules_url == null) && (podium.tournament.rules_url == 0))
                || ((typeof podium.tournament.rules_url == "undefined" || podium.tournament.rules_url == null) && (podium.tournament.is_rules_pdf == 1)) ){
            markup +=  `
                <a class="event__single-link" class="occasion-link" href="${ podium.tournament.is_rules_pdf ? storage + '/' + podium.tournament.rules_pdf : podium.tournament.rules_url }" target="_blank">
                    <h2 class="heading-2--event-title">${dateFormat}</h2>
                    <p class="event__single-paragraphe">${ podium.tournament.title }</p>
                    <p class="event__single-paragraphe">${ podium.tournament.is_accredited ? 'Homologué' : 'Non homologué' }</p>
                    <p class="event__single-paragraphe">${ podium.tournament.place }</p>
                </a>
            `;
        }
        else {
            markup +=  `
                <h2 class="heading-2--event-title">${dateFormat}</h2>
                <p class="event__single-paragraphe">${ podium.tournament.title }</p>
                <p class="event__single-paragraphe">${ podium.tournament.is_accredited ? 'Homologué' : 'Non homologué' }</p>
                <p class="event__single-paragraphe">${ podium.tournament.place }</p>
            `
        }
        markup += `
                </div>
        `;


        // Render second column
        if( (typeof podium.tournament.members !== "undefined" && podium.tournament.members.length > 0)
                || (typeof podium.tournament.teams !== "undefined" && podium.tournament.teams.length > 0) ){
            
            markup +=  `
                <div class="event__single-members event__single-members-ranking">
            `;

            if(podium.tournament.formation == 0 && typeof podium.tournament.members !== "undefined" && podium.tournament.members.length > 0){
                markup += `<div class="event__noteam-rank no-team">`;
                podium.tournament.members.forEach(member => {
                    if(member.pivot.order_display)
                        markup += renderMemberPodiaRanking(member);
                });
                markup += `</div>`;
            }

            if(podium.tournament.formation == 1 && typeof podium.tournament.teams !== "undefined" && podium.tournament.teams.length > 0) {
                podium.tournament.teams.forEach(team => {
                    markup += `<div class="event__team-rank">`;
                    markup += renderTeamPodiaRanking(team);
                    markup += `</div>`;
                });
            }

            markup +=  `
                </div>
                <div class="event__single-members event__single-members-ranking">
            `;
            
            // Render third column
            if(podium.tournament.formation == 0 && typeof podium.tournament.members !== "undefined" && podium.tournament.members.length > 0){
                podium.tournament.members.forEach(member => {
                    if(member.pivot.order_display && member.pivot.rank)
                        markup += `<div class="event__rank-display"> ${member.pivot.rank} </div>`;
                });
            }

            if(podium.tournament.formation == 1 && typeof podium.tournament.teams !== "undefined" && podium.tournament.teams.length > 0){
                podium.tournament.teams.forEach(team => {
                    if(team.order_display && team.rank)
                        markup += `<div class="event__rank-display"> ${team.rank} </div>`;
                });
            }
        }
        markup += `
            </div>
        `;

        return markup;
    }

    const renderMemberPodiaRanking = (member) => {
        if(member.pivot.order_display){
            return renderMember(member);
        }
        return '';
    };

    const renderTeamPodiaRanking = team => {
        let markup = `
            <div class="event__team-rank">
        `;

        team.members.forEach((member, index) => {
            markup += renderMember(member, 1, index);
        });

        markup += `
            </div>
        `;

        return markup;
    };

    const renderMember = (member, type = 0, count = 0) => {
        let storage = url_storage;
        let age = null;

        
        if(typeof member.birth_date !== "undefined" && member.birth_date){
            age = moment(member.birth_date).fromNow(true);
            if(age >= 100){
                age = null;
            }
        }

        let markup = "";

        if(type === 1 && count > 0) {
            markup += `/`;
        }
        else if (type === 0) {
            markup += `<div class="solo-rank">`;
        }
        
        markup += `
                <div class="event__tooltip event__tooltip-ranking ${ member.is_licensee == 'Licencié' ?  'event__tooltip-licensee' : 'event__tooltip-adherent' }">
                    <p class="event__ranking-paragraph ${ member.club_id != 1 ? 'otherClub' : ''}">${ member.last_name } ${ member.first_name }</p>
                    <div class="event__tooltip-event event__tooltip-event-ranking ${ member.is_licensee == 'Licencié' ? 'event__tooltip-event-licensee' : 'event__tooltip-event-adherent' }">
                        <img class="event__tooltip-img" src="${member.picture.length > 0 ? storage + '/' + member.picture[0].path : ''}" alt="Photo de ${ member.last_name } - ${ member.first_name }">
                        <div class="event__tooltip-content">
                            <p class="event__tooltiptext">${ member.last_name } ${ member.first_name } - ${ age ? age : '' } ans</p>
                            <p class="event__tooltiptext">${ member.club.name }</p>
        `;

        if(member.is_licensee === "Licencié"){
            markup += `
                        <p class="event__tooltiptext">Licence : ${ (member.id_licensee) ? member.id_licensee : '' }</p>
                        <p class="event__tooltiptext">${ member.category.title }</p>
                        <p class="event__tooltiptext">Moyenne : ${ (member.score && member.score.average) ? member.score.average : "Pas d'enregistrement" }</p>
                        <p class="event__tooltiptext">Handicap : ${ member.handicap }</p>
                        <p class="event__tooltiptext">Bonus vétéran : ${ member.bonus }</p>
            `;
        }
        else {
            markup += `
                        <p class="event__tooltiptext">${ member.is_licensee }</p>
            `;
        }

        if(type === 0)  {
            markup += `</div>`;
        }
        markup += `
                        
                    </div>
                </div>
            </div>
        `;

        return markup;
    }
}