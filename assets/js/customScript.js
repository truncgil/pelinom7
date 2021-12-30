function px(val) {
        return val + 'px';
    }

    function unpx(val) {
        return pint(val.replace('px', ''));
    }

    function plTr() {
        return $('.planning-board > tbody > tr');
    }

    function firstPlTr() {
        return $('.planning-board > tbody > tr:fisrt');
    }



    $('.scroll-to-left').css({
        //height : px(Math.floor($(window).height() / 2)),
        //top: px(Math.floor($(window).height() / 4)),
        left: '50px'
    });



    function setFlasher(startShift, endShift) {
        let start = startShift.offset();
        let finish = endShift.offset();
        let width = finish.left + endShift.width() - start.left + 20;
        let height = startShift.height() + 20;
        $('<div id="shiftFlasher" style="position:absolute; border: 2px dashed #f00; top: ' + (start.top - 10) +
                'px; left: ' + (start.left - 10) + 'px; width: ' + width + 'px; height:' + height + 'px;"></div>')
            .appendTo($('body'));
        setTimeout(() => {
            $('#shiftFlasher').fadeOut(400, function () {
                removeFlasher();
            });
        }, 5000);
    }

    function removeFlasher() {
        $('#shiftFlasher').remove();
    }

    function removePopover() {
        $('.popover').remove();
    }

    function con(...args) {
        for (let i = 0; i < args.length; i++) {
            console.log(args[i]);
        }
    }

    function checkIntersection(shifts) {
        let ret = true;
        if (Array.isArray(shifts)) {
            for (let i = 0; i < shifts.length; i++) {

                if (shifts[i].html() != "") {
                    //console.log(shifts[i].children());
                    let alt = shifts[i].find('>div')
                    if (alt.hasClass('block-zone'))
                        ret = "block-zone";
                    else if (alt.hasClass('down'))
                        ret = "down";
                    else if (alt.hasClass('setup'))
                        ret = "setup";
                    else if (alt.hasClass('job'))
                        ret = "job";
                    else
                        ret = false;
                    break;
                }
            }
        } else {
            if (shifts.html() != "") {
                //console.log(shifts.children());
                let alt = shifts.find('>div')
                if (alt.hasClass('block-zone'))
                    ret = "block-zone";
                else if (alt.hasClass('down'))
                    ret = "down";
                else if (alt.hasClass('setup'))
                    ret = "setup";
                else if (alt.hasClass('job'))
                    ret = "job";
                else
                    ret = false;
            }
        }
        return ret;
    }

    function checkIntersectionDebug(shifts) {
        let ret = true;
        for (let i = 0; i < shifts.length; i++) {

            if (shifts[i].html() != "") {
                //console.log(shifts[i].children());
                let alt = shifts[i].find('>div')
                if (alt.hasClass('block-zone'))
                    ret = "block-zone";
                else if (alt.hasClass('down'))
                    ret = "down";
                else if (alt.hasClass('setup'))
                    ret = "setup";
                else if (alt.hasClass('job'))
                    ret = alt;
                else
                    ret = false;
                break;
            }
        }
        return ret;
    }

    function getIntersections(shifts) {
        let ret = [];
        for (let i = 0; i < shifts.length; i++) {

            if (shifts[i].html() != "") {
                ret.push(i);
            }
        }
        if (ret.length > 0)
            return ret;
        else
            return false;
    }


    function putIntersecteds(allShifts, e, element) {
        //console.log(allShifts[e]);
        if ($(allShifts[e]).html() != "") {
            putIntersecteds(e + 1);
        } else {
            appendToAndRemove(element, allShifts[e]);
            return e + 1;
        }
    }

    function getAvailableShift(allShifts, e) {
        if ($(allShifts).length < e) {
            return false;
            //console.log("BÜYÜK");
        } else if ($(allShifts).eq(e).html() != '') {
            return getAvailableShift(allShifts, parseInt(e) + 1);
            //console.log(e + ' baktım');
        } else {
            //console.log('TAMAM');
            return e;
        }

    }

    function getAvailableShift2(allShifts, e, whatIsIt = false, draggedElement = false) {
        if ($(allShifts).length < e) {
            return false;
            //console.log("BÜYÜK");
        } else if ($(allShifts).eq(e).html() != '') {
            if (whatIsIt == 'fixedDrag') {
                if ($(allShifts).eq(e).find('>div').hasClass(draggedElement)) {
                    //console.log('YES: ' + e);
                    return getAvailableShift2(allShifts, pint(e) + 1, whatIsIt, draggedElement);

                } else if ($(allShifts).eq(e).html() != "") {

                    return getAvailableShift2(allShifts, pint(e) + 1, whatIsIt, draggedElement);
                } else {
                    //con(draggedElement + ' ' + e);
                    return e;
                }
            } else if (whatIsIt == 'dragAll') {
                /*
                if($(allShifts).eq(e).find('>div').hasClass('job')){
                    return e;
                }
                else{
                    return getAvailableShift2(allShifts, parseInt(e)+1, whatIsIt, draggedElement);
                }
                */

                if ($(allShifts).eq(e).find('>div').hasClass('job')) {
                    return getAvailableShift2(allShifts, pint(e) + 1, whatIsIt, draggedElement);
                } else if ($(allShifts).eq(e).html() != '') {
                    return getAvailableShift2(allShifts, pint(e) + 1, whatIsIt, draggedElement);
                } else {
                    return e;
                }
            } else if (whatIsIt == 'resizableSelector') {
                /*
                if($(allShifts).eq(e).find('>div').hasClass('job')){
                    return e;
                }
                else{
                    return getAvailableShift2(allShifts, parseInt(e)+1, whatIsIt, draggedElement);
                }
                */

                if ($(allShifts).eq(e).find('>div').hasClass('job')) {
                    return getAvailableShift2(allShifts, pint(e) + 1, whatIsIt, draggedElement);
                } else if ($(allShifts).eq(e).html() != '') {
                    return getAvailableShift2(allShifts, pint(e) + 1, whatIsIt, draggedElement);
                } else {
                    return e;
                }
            } else if(whatIsIt == 'customDrag'){
                if ($(allShifts).eq(e).find('>div').hasClass('job')) {
                    return getAvailableShift2(allShifts, pint(e) + 1, whatIsIt, draggedElement);
                } else if ($(allShifts).eq(e).html() != '') {
                    return getAvailableShift2(allShifts, pint(e) + 1, whatIsIt, draggedElement);
                } else {
                    return e;
                }
            }


            //console.log(e + ' baktım');
        } else {
            //console.log('TAMAM');
            return e;
        }
    }

    function nextShift(shift) {
        let all = $('.vardiya');
        let index = all.index(shift);
        return all.eq(index + 1);
    }

    function prevShift(shift) {
        let all = $('.vardiya');
        let index = all.index(shift);
        return all.eq(index - 1);
    }

    function pint(val) {
        return parseInt(val);
    }

    function appendToAndRemove(el, toAppend) {
        let obj = el.clone();
        el.remove();
        obj.appendTo(toAppend);
    }

    function scrollFinish() {
        $('.scroll-to').hide();
    }

    window.scrLeft = 0;

    $('.table-responsive').on('scroll', function () {
        let pl = $('.planning-board').position();
        window.scrLeft = (pl.left - 15) * -1;
    });

    function scrollToLeft() {
        let plBoard = $('.planning-board').width();
        let toScroll;
        if (window.scrLeft - 350 < 0)
            toScroll = 0;
        else
            toScroll = window.scrLeft - 350;

        if (window.scrLeft < 0) {
            window.scrLeft = 0;
        } else {
            $('.table-responsive').scrollLeft(toScroll);
        }
    }

    function scrollToRight() {
        let plBoard = $('.planning-board').width();
        let toScroll;
        if (window.scrLeft + 350 > $('.planning-board').width())
            toScroll = $('.planning-board').width();
        else
            toScroll = window.scrLeft + 350;

        if (window.scrLeft > $('.planning-board').width()) {
            window.scrLeft = $('.planning-board').width();
        } else {
            $('.table-responsive').scrollLeft(toScroll);
        }
    }

    window.leftCheck = false;
    $('.scroll-to-left').on('dragover', function () {

        if (!window.leftCheck) {
            window.leftCheck = true;
            window.timer = setTimeout(() => {
                scrollToLeft();
                window.leftCheck = false;
            }, 650);
        }
    });

    $('.scroll-to-left').on('dragleave', function () {
        clearTimeout(window.timer);
        window.leftCheck = false;
    });


    window.rightCheck = false;
    $('.scroll-to-right').on('dragover', function () {

        if (!window.rightCheck) {
            window.rightCheck = true;
            window.timer = setTimeout(() => {
                scrollToRight();
                window.rightCheck = false;
            }, 650);
        }
    });

    $('.scroll-to-right').on('dragleave', function () {
        clearTimeout(window.timer);
        window.rightCheck = false;
    });

    //let dataToCurr;


    $.fn.id = function(){
	return $(this).attr('id');
}


function drag(el) {
    if ($('#scrollNavigation').is(':checked')) {
        $('.scroll-to').show();
    }

    

    //console.log(ev.pageX);
    //$(document).bind("mouseup", endDragging);
    //console.log(el.attr('jid'));

    removePopover();

    if ($('#fixedDrag').is(':checked')) {


        let jid = el.attr('jid');
        let all = $('.j' + jid + '[jid="' + jid + '"]');
        let thisIndex = all.index(el);

        let toDragObjects = [];
        for (let i = thisIndex; i < all.length; i++) {
            toDragObjects.push(all.eq(i));
        }

        setFlasher(all.eq(0), all.eq(all.length - 1));

        let offset = el.offset();
        //console.log(offset.left);

    } else if ($('#dragAll').is(':checked')) {

        let allJobs = el.parents('.planning-board > tbody > tr').find('.job.fill');
        let allJobsIndex = $('.planning-board > tbody > tr').index(el.parents('.planning-board > tbody > tr'));
        let par = el.parents('.planning-board > tbody > tr');

        let thisIndex = allJobs.index(el);

        let toRightJobs = par.find('.job.fill').slice(thisIndex, allJobs.length);




        let elParentIndex = allJobsIndex;
        let elIndex = thisIndex;
        let allJobsLength = allJobs.length;
        //ev.dataTransfer.setData('text/html', elParentIndex + ';' + elIndex + ';' + allJobsLength);
        setFlasher(allJobs.eq(thisIndex), allJobs.eq(allJobs.length - 1));

    } else if ($('#resizableSelector').is(':checked')) {
        let allJobs = $('.ui-selected.job');
        let allJobsIndex = $('.planning-board > tbody > tr').index(el.parents('.planning-board > tbody > tr'));
        let par = el.parents('.planning-board > tbody > tr');

        let thisIndex = allJobs.index(el);

        let elParentIndex = allJobsIndex;
        let elIndex = thisIndex;
        //console.log(elIndex);
        let allJobsLength = allJobs.length;
        //ev.dataTransfer.setData('text/html', elParentIndex + ';' + elIndex + ';' + allJobsLength);
        setFlasher(allJobs.eq(0), allJobs.eq(allJobs.length - 1));

    } else if (!$('#fixedDrag').is(':checked') && !$('#dragAll').is(':checked') && !$('#resizableSelector').is(
            ':checked')) {
        let allJobs = el.parents('.planning-board > tbody > tr').find('.job.fill');
        let elParentIndex = $('.planning-board > tbody > tr').index(el.parents('.planning-board > tbody > tr'));
        let elIndex = allJobs.index(el);
        //ev.dataTransfer.setData('text/html', elParentIndex + ';' + elIndex);
        setFlasher(el, el);
        //ev.preventDefault();
    }



}




    function drop2(jid, thisIndex, target) {

        $('.vardiya').removeClass('red-bg');

        if ($('#fixedDrag').is(':checked')) {

            var toDragObjects = $('.j' + jid);
            let draggedIndex = parseInt(thisIndex);
            let draggedIndexes = [];
            for (let i = 0 - draggedIndex; i < draggedIndex; i++) {
                draggedIndexes.push(i);
            }

            //console.log(draggedIndexes);


            let allShiftsA = target.attr('workstation');
            // -- allShifts = $('.vardiya[workstation="'+allShiftsA+'"]');
            allShifts = $('.vardiya[workstation="' + allShiftsA + '"]');
            let shiftIndex = parseInt(allShifts.index(target));
            let wholeShifts = [];
            for (let i = 0; i < allShifts.length; i++) {
                wholeShifts.push(allShifts.eq(i));
            }


            let processedShifts = [];
            for (let i = 0; i < toDragObjects.length; i++) {
                processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(draggedIndex) + i));
            }

            removeFlasher();

            let intersection = checkIntersection(processedShifts);
            //console.log(intersection);
            //let con = getAvailableShift('.vardiya[workstation="'+allShiftsA+'"]', 3);



            if (allShifts.length >= toDragObjects.length && pint(shiftIndex) - pint(draggedIndex) >= 0) {
                if (!$('#skipIntersections').is(':checked') && intersection) {

                    //before
                    for (let i = 0; i < toDragObjects.length; i++) {
                        //let currIndex = pint(draggedIndex) + pint(draggedIndexes[i]);
                        let currIndex = i;
                        appendToAndRemove(toDragObjects.eq(currIndex), allShifts.eq(pint(shiftIndex) - pint(
                            draggedIndex) + i));
                        //console.log('toDragIndex: ' + i);
                        //console.log('shiftIndex: ' + (pint(shiftIndex) - pint(draggedIndex) + i));
                    }
                    con('A');
                } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    //console.log(con);
                    for (let i = 0; i < toDragObjects.length; i++) {
                        //eq = putIntersecteds(wholeShifts, eq, toDragObjects.eq(i));
                        let available = getAvailableShift2('.vardiya[workstation="' + allShiftsA + '"]', pint(
                            shiftIndex) - pint(draggedIndex) + i, 'fixedDrag', 'j' + data[0]);
                        //con(available);
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(available));
                    }
                    con('B');
                } else {
                    for (let i = 0; i < toDragObjects.length; i++) {
                        //let currIndex = pint(draggedIndex) + pint(draggedIndexes[i]);
                        let currIndex = i;
                        appendToAndRemove(toDragObjects.eq(currIndex), allShifts.eq(pint(shiftIndex) - pint(
                            draggedIndex) + i));
                        //console.log('toDragIndex: ' + i);
                        //console.log('shiftIndex: ' + (pint(shiftIndex) - pint(draggedIndex) + i));
                    }
                    con('C');
                }

            } else {
                // con('BAYA BAYA');
            }



        } else if ($('#dragAll').is(':checked')) {

            let data = ev.dataTransfer.getData('text/html');
            data = data.split(';');
            //let allJobs = $('.planning-board > tbody > tr').eq(thisIndex);
            let toDragObjects = $('.planning-board > tbody > tr').eq(pint(data[0])).find('.job.fill').slice(pint(data[
                1]), data[2]);

            let elIndex = pint(data[1]);
            let elParentIndex = pint(data[0]);
            let allJobsLength = pint(data[2]);

            removeFlasher();

            let allShiftsA = target.attr('workstation');
            let allShifts = $('.vardiya[workstation="' + allShiftsA + '"]');
            let shiftIndex = pint(allShifts.index(target));

            let processedShifts = [];
            for (let i = 0; i < toDragObjects.length; i++) {
                processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
            }

            let intersection = checkIntersection(processedShifts);

            if (allShifts.length >= toDragObjects.length && pint(shiftIndex) - pint(elIndex) >= 0) {
                if (!$('#skipIntersections').is(':checked') && intersection) {
                    for (let i = 0; i < toDragObjects.length; i++) {
                        appendToAndRemove(toDragObjects.eq(i), allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                    }
                    con('A');
                } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        let available = getAvailableShift2('.vardiya[workstation="' + allShiftsA + '"]', pint(
                            shiftIndex) - pint(elIndex) + i, 'dragAll');
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(available));
                    }
                    con('B');
                } else {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        con('shift Index: ' + shiftIndex + ' - ' + 'Element Index: ' + elIndex + ' - i: ' + i);
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(pint(shiftIndex) /*- pint(elIndex)*/ + i));
                    }
                    con('C');
                }
            } else {}

        } else if ($('#resizableSelector').is(':checked')) {
            let data = ev.dataTransfer.getData('text/html');
            data = data.split(';');
            let toDragObjects = $('.ui-selected.job');

            let elIndex = pint(data[1]);
            let elParentIndex = pint(data[0]);
            let allJobsLength = pint(data[2]);

            removeFlasher();

            let allShiftsA = target.attr('workstation');
            let allShifts = $('.vardiya[workstation="' + allShiftsA + '"]');
            let shiftIndex = pint(allShifts.index(target));

            let processedShifts = [];
            for (let i = 0; i < toDragObjects.length; i++) {
                processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
            }

            let intersection = checkIntersection(processedShifts);


            if (allShifts.length >= toDragObjects.length && (shiftIndex - elIndex) >= 0) {
                if (!$('#skipIntersections').is(':checked') && intersection) {
                    for (let i = 0; i < toDragObjects.length; i++) {
                        appendToAndRemove(toDragObjects.eq(i), allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                    }
                    con('A');
                } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        let available = getAvailableShift2('.vardiya[workstation="' + allShiftsA + '"]', pint(
                            shiftIndex) - pint(elIndex) + i, 'resizableSelector');
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(available));
                    }
                    con('B');
                } else {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        //con('shift Index: ' + shiftIndex + ' - ' + 'Element Index: ' + elIndex + ' - i: ' + i);
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                    }
                    con('CCC');
                }
            }



        } else if (!$('#fixedDrag').is(':checked') && !$('#dragAll').is(':checked') && !$('#resizableSelector').is(
                ':checked')) {

            let dataPromise = new Promise(resolve => {
                let dataProm = ev.dataTransfer.getData('text/html');
                resolve(dataProm);
            });

            (async function () {
                let data = await dataPromise;
                data = await data.split(';');
                let elIndex = await pint(data[1]);
                let elParentIndex = await pint(data[0]);
                let toDragObject = await $('.planning-board > tbody > tr').eq(elParentIndex).find('.job').eq(
                    elIndex);

                await removeFlasher();

                let allShiftsA = await target.attr('workstation');
                let allShifts = await $('.vardiya[workstation="' + allShiftsA + '"]');
                let shiftIndex = await pint(allShifts.index(target));

                /*
                let processedShifts = await [];
                for (let i = 0; i < toDragObject.length; i++) {
                    await processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                }
                */
                let processedShifts = await allShifts.eq(pint(shiftIndex));
                //console.log('asdasd' + (pint(shiftIndex) - pint(elIndex)));

                let intersection = await checkIntersection(processedShifts);

                
                if (!$('#skipIntersections').is(':checked') && intersection) {
                    for (let i = 0; i < toDragObject.length; i++) {
                        await appendToAndRemove(toDragObject.eq(i), allShifts.eq(pint(shiftIndex) - pint(
                            elIndex) + i));
                    }
                    await con('A');
                } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                    let toObjs = await toDragObject.clone();
                    await toDragObject.remove();
                    //for (let i = 0; i < toObjs.length; i++) {
                    let available = await getAvailableShift2('.vardiya[workstation="' + allShiftsA +
                        '"]', pint(
                            shiftIndex), 'customDrag');
                    await appendToAndRemove(toObjs, allShifts.eq(available));
                    //}
                    await console.log(available);
                    await con('B');
                } else {
                    let toObjs = await toDragObject.clone();
                    await toDragObject.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        await con('shift Index: ' + shiftIndex + ' - ' + 'Element Index: ' + elIndex +
                            ' - i: ' + i);
                        await appendToAndRemove(toObjs.eq(i), allShifts.eq(pint(shiftIndex) + i));
                    }
                    await console.log(intersection);
                    await con('C');
                }
               

            })();

        } else {
            ev.preventDefault();
        }



    }
	
	function drop(ev, target) {

        $('.vardiya').removeClass('red-bg');

        ev.preventDefault();

        if ($('#fixedDrag').is(':checked')) {


            let data = ev.dataTransfer.getData("text/html");
            let oldPositions = ev.dataTransfer.getData('oldPositions');
            data = data.split(';');
            var toDragObjects = $('.j' + data[0]);
            let draggedIndex = parseInt(data[1]);
            let draggedIndexes = [];
            for (let i = 0 - draggedIndex; i < draggedIndex; i++) {
                draggedIndexes.push(i);
            }

            //console.log(draggedIndexes);


            let allShiftsA = target.attr('workstation');
            // -- allShifts = $('.vardiya[workstation="'+allShiftsA+'"]');
            allShifts = $('.vardiya[workstation="' + allShiftsA + '"]');
            let shiftIndex = parseInt(allShifts.index(target));
            let wholeShifts = [];
            for (let i = 0; i < allShifts.length; i++) {
                wholeShifts.push(allShifts.eq(i));
            }


            let processedShifts = [];
            for (let i = 0; i < toDragObjects.length; i++) {
                processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(draggedIndex) + i));
            }

            removeFlasher();

            let intersection = checkIntersection(processedShifts);
            //console.log(intersection);
            //let con = getAvailableShift('.vardiya[workstation="'+allShiftsA+'"]', 3);



            if (allShifts.length >= toDragObjects.length && pint(shiftIndex) - pint(draggedIndex) >= 0) {
                if (!$('#skipIntersections').is(':checked') && intersection) {

                    //before
                    for (let i = 0; i < toDragObjects.length; i++) {
                        //let currIndex = pint(draggedIndex) + pint(draggedIndexes[i]);
                        let currIndex = i;
                        appendToAndRemove(toDragObjects.eq(currIndex), allShifts.eq(pint(shiftIndex) - pint(
                            draggedIndex) + i));
                        //console.log('toDragIndex: ' + i);
                        //console.log('shiftIndex: ' + (pint(shiftIndex) - pint(draggedIndex) + i));
                    }
                    con('A');
                } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    //console.log(con);
                    for (let i = 0; i < toDragObjects.length; i++) {
                        //eq = putIntersecteds(wholeShifts, eq, toDragObjects.eq(i));
                        let available = getAvailableShift2('.vardiya[workstation="' + allShiftsA + '"]', pint(
                            shiftIndex) - pint(draggedIndex) + i, 'fixedDrag', 'j' + data[0]);
                        //con(available);
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(available));
                    }
                    con('B');
                } else {
                    for (let i = 0; i < toDragObjects.length; i++) {
                        //let currIndex = pint(draggedIndex) + pint(draggedIndexes[i]);
                        let currIndex = i;
                        appendToAndRemove(toDragObjects.eq(currIndex), allShifts.eq(pint(shiftIndex) - pint(
                            draggedIndex) + i));
                        //console.log('toDragIndex: ' + i);
                        //console.log('shiftIndex: ' + (pint(shiftIndex) - pint(draggedIndex) + i));
                    }
                    con('C');
                }

            } else {
                // con('BAYA BAYA');
            }



        } else if ($('#dragAll').is(':checked')) {

            let data = ev.dataTransfer.getData('text/html');
            data = data.split(';');
            //let allJobs = $('.planning-board > tbody > tr').eq(thisIndex);
            let toDragObjects = $('.planning-board > tbody > tr').eq(pint(data[0])).find('.job.fill').slice(pint(data[
                1]), data[2]);

            let elIndex = pint(data[1]);
            let elParentIndex = pint(data[0]);
            let allJobsLength = pint(data[2]);

            removeFlasher();

            let allShiftsA = target.attr('workstation');
            let allShifts = $('.vardiya[workstation="' + allShiftsA + '"]');
            let shiftIndex = pint(allShifts.index(target));

            let processedShifts = [];
            for (let i = 0; i < toDragObjects.length; i++) {
                processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
            }

            let intersection = checkIntersection(processedShifts);

            if (allShifts.length >= toDragObjects.length && pint(shiftIndex) - pint(elIndex) >= 0) {
                if (!$('#skipIntersections').is(':checked') && intersection) {
                    for (let i = 0; i < toDragObjects.length; i++) {
                        appendToAndRemove(toDragObjects.eq(i), allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                    }
                    con('A');
                } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        let available = getAvailableShift2('.vardiya[workstation="' + allShiftsA + '"]', pint(
                            shiftIndex) - pint(elIndex) + i, 'dragAll');
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(available));
                    }
                    con('B');
                } else {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        con('shift Index: ' + shiftIndex + ' - ' + 'Element Index: ' + elIndex + ' - i: ' + i);
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(pint(shiftIndex) /*- pint(elIndex)*/ + i));
                    }
                    con('C');
                }
            } else {}

        } else if ($('#resizableSelector').is(':checked')) {
            let data = ev.dataTransfer.getData('text/html');
            data = data.split(';');
            let toDragObjects = $('.ui-selected.job');

            let elIndex = pint(data[1]);
            let elParentIndex = pint(data[0]);
            let allJobsLength = pint(data[2]);

            removeFlasher();

            let allShiftsA = target.attr('workstation');
            let allShifts = $('.vardiya[workstation="' + allShiftsA + '"]');
            let shiftIndex = pint(allShifts.index(target));

            let processedShifts = [];
            for (let i = 0; i < toDragObjects.length; i++) {
                processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
            }

            let intersection = checkIntersection(processedShifts);


            if (allShifts.length >= toDragObjects.length && (shiftIndex - elIndex) >= 0) {
                if (!$('#skipIntersections').is(':checked') && intersection) {
                    for (let i = 0; i < toDragObjects.length; i++) {
                        appendToAndRemove(toDragObjects.eq(i), allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                    }
                    con('A');
                } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        let available = getAvailableShift2('.vardiya[workstation="' + allShiftsA + '"]', pint(
                            shiftIndex) - pint(elIndex) + i, 'resizableSelector');
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(available));
                    }
                    con('B');
                } else {
                    let toObjs = toDragObjects.clone();
                    toDragObjects.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        //con('shift Index: ' + shiftIndex + ' - ' + 'Element Index: ' + elIndex + ' - i: ' + i);
                        appendToAndRemove(toObjs.eq(i), allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                    }
                    con('CCC');
                }
            }



        } else if (!$('#fixedDrag').is(':checked') && !$('#dragAll').is(':checked') && !$('#resizableSelector').is(
                ':checked')) {

            let dataPromise = new Promise(resolve => {
                let dataProm = ev.dataTransfer.getData('text/html');
                resolve(dataProm);
            });

            (async function () {
                let data = await dataPromise;
                data = await data.split(';');
                let elIndex = await pint(data[1]);
                let elParentIndex = await pint(data[0]);
                let toDragObject = await $('.planning-board > tbody > tr').eq(elParentIndex).find('.job').eq(
                    elIndex);

                await removeFlasher();

                let allShiftsA = await target.attr('workstation');
                let allShifts = await $('.vardiya[workstation="' + allShiftsA + '"]');
                let shiftIndex = await pint(allShifts.index(target));

                /*
                let processedShifts = await [];
                for (let i = 0; i < toDragObject.length; i++) {
                    await processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                }
                */
                let processedShifts = await allShifts.eq(pint(shiftIndex));
                //console.log('asdasd' + (pint(shiftIndex) - pint(elIndex)));

                let intersection = await checkIntersection(processedShifts);

                
                if (!$('#skipIntersections').is(':checked') && intersection) {
                    for (let i = 0; i < toDragObject.length; i++) {
                        await appendToAndRemove(toDragObject.eq(i), allShifts.eq(pint(shiftIndex) - pint(
                            elIndex) + i));
                    }
                    await con('A');
                } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                    let toObjs = await toDragObject.clone();
                    await toDragObject.remove();
                    //for (let i = 0; i < toObjs.length; i++) {
                    let available = await getAvailableShift2('.vardiya[workstation="' + allShiftsA +
                        '"]', pint(
                            shiftIndex), 'customDrag');
                    await appendToAndRemove(toObjs, allShifts.eq(available));
                    //}
                    await console.log(available);
                    await con('B');
                } else {
                    let toObjs = await toDragObject.clone();
                    await toDragObject.remove();
                    for (let i = 0; i < toObjs.length; i++) {
                        await con('shift Index: ' + shiftIndex + ' - ' + 'Element Index: ' + elIndex +
                            ' - i: ' + i);
                        await appendToAndRemove(toObjs.eq(i), allShifts.eq(pint(shiftIndex) + i));
                    }
                    await console.log(intersection);
                    await con('C');
                }
               

            })();
            /*
            (async function(){
                let data = await ev.dataTransfer.getData('text/html');
                data = await data.split(';');
                let elIndex = await pint(data[1]);
                let elParentIndex = await pint(data[0]);
                let toDragObject = await $('.planning-board > tbody > tr').eq(elParentIndex).find('.job').eq(elIndex);

                await removeFlasher();

                let allShiftsA = await target.attr('workstation');
                let allShifts = await $('.vardiya[workstation="'+ allShiftsA +'"]');
                let shiftIndex = await pint(allShifts.index(target));

                let processedShifts = await [];
                for (let i = 0; i < toDragObject.length; i++) {
                    await processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                }
                console.log('asdasd' + (pint(shiftIndex) - pint(elIndex)));

                let intersection = await checkIntersection(processedShifts);

                if (allShifts.length >= toDragObject.length && pint(shiftIndex) - pint(elIndex) >= 0) {
                    if (!$('#skipIntersections').is(':checked') && intersection) {
                        for (let i = 0; i < toDragObject.length; i++) {
                            await appendToAndRemove(toDragObject.eq(i), allShifts.eq(pint(shiftIndex) - pint(elIndex) + i));
                        }
                        await con('A');
                    } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                        let toObjs = await toDragObject.clone();
                        await toDragObject.remove();
                        for (let i = 0; i < toObjs.length; i++) {
                            let available = await getAvailableShift2('.vardiya[workstation="' + allShiftsA + '"]', pint(
                                shiftIndex) - pint(elIndex) + i, 'dragAll');
                            await appendToAndRemove(toObjs.eq(i), allShifts.eq(available));
                        }
                        await console.log(processedShifts[0]);
                        await con('B');
                    } else {
                        let toObjs = await toDragObject.clone();
                        await toDragObject.remove();
                        for (let i = 0; i < toObjs.length; i++) {
                            await con('shift Index: ' + shiftIndex + ' - ' + 'Element Index: ' + elIndex + ' - i: ' + i);
                            await appendToAndRemove(toObjs.eq(i), allShifts.eq(pint(shiftIndex) + i));
                        }
                        await console.log(intersection);
                        await con('C');
                    }
                } else {}

            })();
            */

        } else {
            ev.preventDefault();
        }



    }

    //let dragEnterEventTimeout;

    function dragEnterEvent(ev, el){
        clearTimeout(dragEnterEventTimeout);
        dragEnterEventTimeout = setTimeout(function(){
            
            let target = el;
            
            let elements = $('.job');
            let curr;
            let i = 0;
            
            if($('#fixedDrag').is(':checked')){

                let data = dataToCurr;
                let oldPositions = ev.dataTransfer.getData('oldPositions');
                data = data.split(';');
                var toDragObjects = $('.j' + data[0]);
                let draggedIndex = parseInt(data[1]);
                let draggedIndexes = [];
                for (let i = 0 - draggedIndex; i < draggedIndex; i++) {
                    draggedIndexes.push(i);
                }

                //console.log(draggedIndexes);


                let allShiftsA = target.attr('workstation');
                // -- allShifts = $('.vardiya[workstation="'+allShiftsA+'"]');
                allShifts = $('.vardiya[workstation="' + allShiftsA + '"]');
                let shiftIndex = parseInt(allShifts.index(target));
                let wholeShifts = [];
                for (let i = 0; i < allShifts.length; i++) {
                    wholeShifts.push(allShifts.eq(i));
                }


                let processedShifts = [];
                for (let i = 0; i < toDragObjects.length; i++) {
                    processedShifts.push(allShifts.eq(pint(shiftIndex) - pint(draggedIndex) + i));
                }

                removeFlasher();

                let intersection = checkIntersection(processedShifts);
                //console.log(intersection);
                //let con = getAvailableShift('.vardiya[workstation="'+allShiftsA+'"]', 3);



                if (allShifts.length >= toDragObjects.length && pint(shiftIndex) - pint(draggedIndex) >= 0) {
                    if (!$('#skipIntersections').is(':checked') && intersection) {

                        //before
                        for (let i = 0; i < toDragObjects.length; i++) {
                            //let currIndex = pint(draggedIndex) + pint(draggedIndexes[i]);
                            let currIndex = i;
                            allShifts.eq(pint(shiftIndex) - pint(draggedIndex) + i).addClass('red-bg');
                            //console.log('toDragIndex: ' + i);
                            //console.log('shiftIndex: ' + (pint(shiftIndex) - pint(draggedIndex) + i));
                        }
                    } else if ($('#skipIntersections').is(':checked') && intersection != true) {
                        let toObjs = toDragObjects.clone();
                        //console.log(con);
                        for (let i = 0; i < toDragObjects.length; i++) {
                            //eq = putIntersecteds(wholeShifts, eq, toDragObjects.eq(i));
                            let available = getAvailableShift2('.vardiya[workstation="' + allShiftsA + '"]', pint(
                                shiftIndex) - pint(draggedIndex) + i, 'fixedDrag', 'j' + data[0]);
                            //con(available);
                            allShifts.eq(available).addClass('red-bg');
                            //appendToAndRemove(toObjs.eq(i), );
                        }
                    } else {
                        for (let i = 0; i < toDragObjects.length; i++) {
                            //let currIndex = pint(draggedIndex) + pint(draggedIndexes[i]);
                            let currIndex = i;
                            allShifts.eq(pint(shiftIndex) - pint( draggedIndex) + i).addClass('red-bg');
                            //appendToAndRemove(toDragObjects.eq(currIndex), );

                            //console.log('toDragIndex: ' + i);
                            //console.log('shiftIndex: ' + (pint(shiftIndex) - pint(draggedIndex) + i));
                        }
                    }

                } else {
                    // con('BAYA BAYA');
                }

            }
        }, 200);















    }

    function dragLeaveEvent(event, el){
        el.removeClass('red-bg');
        $('.vardiya').removeClass('red-bg');
    }

    function dragEndEvent(event, el){
        el.removeClass('red-bg');
        $('.vardiya').removeClass('red-bg');
    }




    // ! Resizable Selector
    function insertSelector(position, callback = function () {}) {
        let appendTo = $('.planning-board');
        appendTo.append(
            '<div id="selectResize" draggable="true" ondragstart="resizable_drag_start(event);" style="resize:both; overflow: auto; position: absolute; top: ' +
            position.y + 'px; left: ' + position.x +
            'px; width: 100px; height: 100px; border: 1px solid #298cff; background-color: rgba(41, 140, 255, 0.4); z-index: 999999999999999999999999999999999999999999; cursor: move;"></div>'
        );
        callback();
    }

    function resizable_drag_start(event) {
        console.log('AAA');
        var style = window.getComputedStyle(event.target, null);
        event.dataTransfer.setData("text/plain",
            (parseInt(style.getPropertyValue("left"), 10) - event.clientX) + ',' + (parseInt(style.getPropertyValue(
                "top"), 10) - event.clientY));
    }

    function resizable_drag_over(event) {
        event.preventDefault();
        return false;
    }

    function innerJobs(pos) {
        console.log(pos);
    }

    function resizable_drop(event) {
        var offset = event.dataTransfer.getData("text/plain").split(',');
        var dm = document.getElementById('selectResize');
        dm.style.left = (event.clientX + parseInt(offset[0], 10)) + 'px';
        dm.style.top = (event.clientY + parseInt(offset[1], 10)) + 'px';
        innerJobs({
            x: (event.clientX + parseInt(offset[0], 10)),
            y: (event.clientY + parseInt(offset[1], 10))
        });
        event.preventDefault();
        return false;
    }
    // / Resizable Selector

    $.fn.mouseDownUp = function (mouseDownFn = function () {}, mouseUpFn = function () {}) {
        $(this).on('mousedown', function () {
            mouseDownFn();
        }).on('mouseup', function () {
            mouseUpFn();
        });
    }


    function drawRectangle() {
        $('.planning-board').append(
            '<div id="selectResize" draggable="true" ondragstart="resizable_drag_start(event);" style="resize:both; overflow: auto; position: absolute; top: ' +
            position.y + 'px; left: ' + position.x +
            'px; width: 100px; height: 100px; border: 1px solid #298cff; background-color: rgba(41, 140, 255, 0.4); z-index: 999999999999999999999999999999999999999999; cursor: move;"></div>'
        );
    }

    $.fn.dShow = function () {
        $(this).css('display', 'block');
    }
    $.fn.dHide = function () {
        $(this).css('display', 'none');
    }

    $('#resizableSelector').on('change', function () {
        if ($(this).is(':checked')) {
            $('#resetMultiSelector').dShow();
            /*
            insertSelector({ x: 100, y: 200 }, function(){
                $('body').attr('ondragover', 'resizable_drag_over(event);');
                $('body').attr('ondrop', 'resizable_drop(event)');
            });
            */
            $('.job').toggleClass('ui-widget-content');
            $('.planning-board > tbody > tr').selectable({
                filter: '.job',
                selected: function () {
                    //$('.planning-board > tbody > tr').selectable('destroy');
                    $('.planning-board > tbody > tr').unbind();
                }
            });
            $('#resetMultiSelector').on('click', function () {
                $('.planning-board > tbody > tr').selectable('destroy');
                $('.ui-selected').removeClass('ui-selected');
                $('.planning-board > tbody > tr').selectable({
                    filter: '.job',
                    selected: function () {
                        //$('.planning-board > tbody > tr').selectable('destroy');
                        $('.planning-board > tbody > tr').unbind();
                    }
                });
                $('.job').removeClass('ui-selected');
            });
        } else {
            $('#resetMultiSelector').dHide();
        }
    });