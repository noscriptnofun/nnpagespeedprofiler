/**
 * @Author: andreasprietzel
 * @Date:   2020-04-10T14:05:10+02:00
 * @Last modified by:   andreasprietzel
 * @Last modified time: 2020-08-04T13:39:02+02:00
*/

function NNPageSpeedController()
{
	this.lang = '';
	this.runPageSpeedWith              = runPageSpeedWith;
	this.savePageSpeedResultWith       = savePageSpeedResultWith;
	this.runNextPageSpeedTestFromArray = runNextPageSpeedTestFromArray;
	this.onRunMultiPageSpeedTestClick    = onRunMultiPageSpeedTestClick;
	this.onRunSinglePageSpeedTestClick = onRunSinglePageSpeedTestClick;

	function _init()
	{
		console.log('Init NNPageSpeedController');
		_initEvents.apply(this);
	}

	function _initEvents()
	{

	}

	function _getAllPagesByPageID(thePageID)
	{
		var result = [];
		if (window.pageSpeedWebsites.hasOwnProperty(thePageID))
		{
			if (window.pageSpeedWebsites[thePageID].url !== '')
			{
				result.push(window.pageSpeedWebsites[thePageID]);
			}
			for (theIndex in window.pageSpeedWebsites)
			{
				if (window.pageSpeedWebsites.hasOwnProperty(theIndex))
				{
					if (window.pageSpeedWebsites[theIndex].pid === thePageID)
					{
						result = result.concat(_getAllPagesByPageID(theIndex*1));
					}
				}
			}
		}
		return result;
	}

	function runPageSpeedWith(theWebsiteObj, theStrategy, theCallbackFunction)
	{
		setTimeout(function ()
		{
			var lang = (window.pageSpeedController.lang !== '') ? window.pageSpeedController.lang : 'en';
			var url = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='+theWebsiteObj.url+'&strategy='+theStrategy+'&screenshot=false&locale='+lang;

			if ((theWebsiteObj.hasOwnProperty('apikey')) && (theWebsiteObj.apikey.trim() !== ''))
			{
				url += '&key='+theWebsiteObj.apikey;
			}
			console.log('NNPageSpeedController.runPageSpeedWith('+url+','+theStrategy+', theCallbackFunction)');

			var theRequest = new XMLHttpRequest();
			theRequest.onreadystatechange = function()
			{
				if(theRequest.readyState === XMLHttpRequest.DONE)
				{
					var status = theRequest.status;
					if (status === 0 || (status >= 200 && status < 400))
					{
						if (typeof theCallbackFunction === 'function')
						{
							theCallbackFunction( JSON.parse( theRequest.responseText ) );
						}
				    } else
					{
						var errorMessage = 'ERROR: Request '+url+' - Status: '+status;
						jQuery('.Results .'+theStrategy+' .Audits').html(errorMessage);
						console.error(errorMessage);
						if (typeof theCallbackFunction === 'function')
						{
							theCallbackFunction( -1 );
						}
					}
				}
			}
			theRequest.open('GET', url, true);
			theRequest.send(null);
		}, 1000);
	}

	function savePageSpeedResultWith(theID, theStrategy, theScore, theResponse, theTimestamp, theRequestToken)
	{
		theResponse = btoa(encodeURIComponent(theResponse));
		params = 'id='+theID+'&strategy='+theStrategy+'&score='+theScore+'&response='+theResponse+'&timestamp='+theTimestamp;
		theRequest = new XMLHttpRequest();
		theRequestURL = '/savennpagespeedprofilerresult';
		theRequest.open('POST', theRequestURL, true);
		theRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		theRequest.send(params);
	}

	function runNextPageSpeedTestFromArray(theWebsiteArray)
	{
		var _this = this;
		var theWebsite = theWebsiteArray.shift();
		jQuery('#website'+theWebsite.id).addClass('Progress');

		this.runPageSpeedWith(theWebsite, 'mobile', function(theResponseData)
		{
			if (typeof theResponseData === 'object')
			{
				var theScore = theResponseData.lighthouseResult.categories.performance.score;
				jQuery('#website'+theWebsite.id+' .Score .Mobile').html('Mobile:'+Math.trunc(theScore*100));
				_this.savePageSpeedResultWith(theWebsite.id, 'mobile', theScore, JSON.stringify(theResponseData), _this.timestamp, _this.requestToken);
				_this.runPageSpeedWith(theWebsite, 'desktop', function(theResponseData)
				{
					if (typeof theResponseData === 'object')
					{
						var theScore = theResponseData.lighthouseResult.categories.performance.score;
						jQuery('#website'+theWebsite.id+' .Score .Desktop').html('Desktop:'+Math.trunc(theScore*100));
						_this.savePageSpeedResultWith(theWebsite.id, 'desktop', theScore, JSON.stringify(theResponseData), _this.timestamp, _this.requestToken);
						jQuery('#website'+theWebsite.id).removeClass('Progress');
						jQuery('#website'+theWebsite.id).addClass('Checked');
						if (theWebsiteArray.length>0)
						{
							_this.runNextPageSpeedTestFromArray(theWebsiteArray);
						}
					} else
					{//Fehlerhaftes Ergebnis:
						//Weiter zur nächsten URL
						jQuery('#website'+theWebsite.id).removeClass('Progress');
						jQuery('#website'+theWebsite.id).addClass('Failed');
						if (theWebsiteArray.length>0)
						{
							_this.runNextPageSpeedTestFromArray(theWebsiteArray);
						}
					}
				});
			} else
			{//Fehlerhaftes Ergebnis:
				//Weiter zur nächsten URL
				jQuery('#website'+theWebsite.id).removeClass('Progress');
				jQuery('#website'+theWebsite.id).addClass('Failed');
				if (theWebsiteArray.length>0)
				{
					_this.runNextPageSpeedTestFromArray(theWebsiteArray);
				}
			}
		});
	}

	function onRunMultiPageSpeedTestClick(theID, theRequestToken, theLang)
	{

		window.pageSpeedController.lang = theLang;
		window.pageSpeedController.timestamp = new Date().getTime()/1000
		window.pageSpeedController.requestToken = theRequestToken;

		var listOfWebsites = _getAllPagesByPageID(theID);
		var html = '<div class="NNPageSpeedResultBox">';
		html += '<ul class="Websites">';
		listOfWebsites.forEach(function(theWebsite)
		{
			html += '<li id="website'+theWebsite.id+'" class="">';
			html += '<span class="Score"><span class="Mobile"></span><span class="Desktop"></span></span> - '+theWebsite.url;
			html += '</li>';

		});
		html += '</ul>';
		html += '</div>';
		jQuery.colorbox({html:html, width:"90%", height:"85%"});

		this.runNextPageSpeedTestFromArray(listOfWebsites);

	}

	function onRunSinglePageSpeedTestClick(theID, theRequestToken, theLang)
	{
		var theTimestamp = new Date().getTime()/1000;
		window.pageSpeedController.lang = theLang;
		if (window.pageSpeedWebsites.hasOwnProperty(theID))
		{
			var theWebsite = window.pageSpeedWebsites[theID];
			var mobileResultPage = new ResultHTMLPage('mobile');
			var desktopResultPage = new ResultHTMLPage('desktop');

			var html = '<div class="NNPageSpeedResultBox">';
			html += '<h1>'+theWebsite.url+'</h1>';
			html += '<div class="Results">';
			html += mobileResultPage.render();
			html += desktopResultPage.render();
			html += '</div>';
			html += '</div>';

			jQuery.colorbox({html:html, width:"90%", height:"85%"});

			window.pageSpeedController.runPageSpeedWith(theWebsite, 'desktop', function(theResponseData)
			{
				if ((typeof theResponseData === 'object') && (!theResponseData.hasOwnProperty('error')))
				{
					var theScore = theResponseData.lighthouseResult.categories.performance.score;
					desktopResultPage.setScore(theScore);
					desktopResultPage.processAudits(theResponseData.lighthouseResult.audits);
					window.pageSpeedController.savePageSpeedResultWith(theID, 'desktop', theScore, JSON.stringify(theResponseData), theTimestamp, theRequestToken);
				} else
				{
					console.error('NNPageSpeed ERROR: code ',theResponseData.error.code,' message: ',theResponseData.error.message);
				}
			});
			setTimeout(function () {
				window.pageSpeedController.runPageSpeedWith(theWebsite, 'mobile', function(theResponseData)
				{
					if ((typeof theResponseData === 'object') && (!theResponseData.hasOwnProperty('error')))
					{
						var theScore = theResponseData.lighthouseResult.categories.performance.score;
						mobileResultPage.setScore(theScore);
						mobileResultPage.processAudits(theResponseData.lighthouseResult.audits);
						window.pageSpeedController.savePageSpeedResultWith(theID, 'mobile', theScore, JSON.stringify(theResponseData), theTimestamp, theRequestToken);
					} else
					{
						console.error('NNPageSpeed ERROR: code ',theResponseData.error.code,' message: ',theResponseData.error.message);
					}
				});
			}, 600);
		}
	}

	_init.apply(this);
}

function ResultHTMLPage(thePageName, thePageClass)
{
	if (thePageClass === undefined)
	{
		thePageClass = thePageName;
	}
	this.getScoreColor = getScoreColor;
	this.setScore = setScore;
	this.processAudits = processAudits;
	this.render = render;
	this.colorTable = ['rgb(255,69,58)', 'rgb(255,214,10)', 'rgb(48,209,88)'];

	function getScoreColor(forTheScore)
	{
		var result = this.colorTable[0];
		if (forTheScore>0.89)
		{
			result = this.colorTable[2];
		} else
		if (forTheScore>0.49)
		{
			result = this.colorTable[1];
		}
		return result;
	}

	function setScore(theScore)
	{
		var theResultTag = jQuery('.'+thePageClass+' .TheResult');
		var theColor = this.getScoreColor(theScore);

		theResultTag.css({color:theColor,borderColor:theColor});

		theResultTag.html(Math.round(theScore*100));
		jQuery('.'+thePageClass+' .spinner').hide();
	}

	function processAudits(allAudits)
	{
		var indexKey;
		var htmlWithDetails = '';
		var htmlWithoutDetails = '';
		var htmlAuditResult = '';
		var theAudit = {};
		var allAuditsInAnArray = [];
		var hasDetails = false;

		allAuditsInAnArray = Object.keys(allAudits).map(function(key) {
  			return allAudits[key];
		});

		allAuditsInAnArray = allAuditsInAnArray.sort(function(a, b)
		{
			var comparison = 0;
			if (a.id > b.id)
			{
				comparison = 1;
			} else
			if (a.id < b.id)
			{
				comparison = -1;
			}
			return comparison;
		});

		for (indexKey in allAuditsInAnArray)
		{
			htmlAuditResult = '';
			if (allAuditsInAnArray.hasOwnProperty(indexKey))
			{
				theAudit = allAuditsInAnArray[indexKey];

				if (theAudit.score !== null)
				{
					hasDetails = ((theAudit.hasOwnProperty('details')) && (theAudit.details.hasOwnProperty('items')) && (theAudit.details.hasOwnProperty('headings')) && (theAudit.details.headings.length > 0));
					if (hasDetails)
					{
						htmlAuditResult += '<div class="Audit HasDetails" onclick="'+"jQuery(this).toggleClass('Open');"+'">';
					} else
					{
						htmlAuditResult += '<div class="Audit">';
					}

					htmlAuditResult += '<h3>'+theAudit.title+'</h3>';
					htmlAuditResult += '<span class="ScoreColor" style="background-color:'+this.getScoreColor(theAudit.score)+'"></span>';

					if (hasDetails)
					{
						htmlAuditResult += '<span class="ShowMoreIcon"></span>';
					}


					if (theAudit.hasOwnProperty('displayValue'))
					{
						htmlAuditResult += '<span class="Value">'+theAudit.displayValue+'</span>';
					}

					if (theAudit.hasOwnProperty('description'))
					{
						//all links:
						var allLinkMatches = theAudit.description.match(/\[.*\]\(.*\)/gm)
						if (allLinkMatches !== null)
						{
							allLinkMatches.forEach(function(theLinkMatch)
							{
								var theSplitedLink = theLinkMatch.split('](')
								var text = theSplitedLink[0].substr(1);
								var link = theSplitedLink[1].slice(0, -1);
								theAudit.description = theAudit.description.replace(theLinkMatch, '<a href="'+link+'" target="_blank">'+text+'</a>')
							});
						}


						htmlAuditResult += '<span class="Help" onclick="'+"jQuery(this).parent().find('.DescriptionToolTip').toggleClass('Show');"+'">?</span><span class="DescriptionToolTip">'+theAudit.description+'</span>';
					}

					if (hasDetails)
					{
						htmlAuditResult += '<table>';
						htmlAuditResult += '<thead><tr>';
						var keys = [];
						var headings = [];

						theAudit.details.headings.forEach(function(theHeadingObj)
						{
							if (theHeadingObj.hasOwnProperty('text'))
							{
								htmlAuditResult += '<th>'+theHeadingObj.text+'</th>';
								headings[theHeadingObj.key] = theHeadingObj.text;
							} else
							if (theHeadingObj.hasOwnProperty('label'))
							{
								htmlAuditResult += '<th>'+theHeadingObj.label+'</th>';
								headings[theHeadingObj.key] = theHeadingObj.label;
							}
							keys.push(theHeadingObj.key);
						});
						htmlAuditResult += '</thead></tr>';

						htmlAuditResult += '<tbody>';

						theAudit.details.items.forEach(function(theItem)
						{
							htmlAuditResult += '<tr>';
							usedKeys = [];
							keys.forEach(function(theKey)
							{
								if ((theItem.hasOwnProperty(theKey)) && (usedKeys.indexOf(theKey) === -1))
								{
									if (typeof theItem[theKey] === 'object')
									{
										if (theItem[theKey].hasOwnProperty('type'))
										{
											switch (theItem[theKey].type)
											{
												case 'link':
												{
													var theValue = theItem[theKey].text+': '+theItem[theKey].url;

													if (theValue.length > 50)
													{
														htmlAuditResult += '<td class="HasTooltip" data-label="'+headings[theKey]+'">'+String(theValue).substr(0,50)+'...'+'<span class="Tooltiptext">'+theItem[theKey]+'</span></td>';
													} else
													{
														htmlAuditResult += '<td data-label="'+headings[theKey]+'">'+theValue+'</td>';
													}
													break;
												}
												default:
											}
										}
									} else
									if (String(theItem[theKey]).length > 50)
									{
										htmlAuditResult += '<td class="HasTooltip" data-label="'+headings[theKey]+'">'+String(theItem[theKey]).substr(0,50)+'...<span class="Tooltiptext">'+theItem[theKey]+'</span></td>';
									} else
									{
										htmlAuditResult += '<td data-label="'+headings[theKey]+'">'+theItem[theKey]+'</td>';
									}
									usedKeys.push(theKey);
								}
							});
							htmlAuditResult += '</tr>';
						});

						htmlAuditResult += '</tbody>';
						htmlAuditResult += '</table>';
					}

					htmlAuditResult += '</div>';

					if (hasDetails)
					{//has details:
						htmlWithDetails += htmlAuditResult;
					} else
					{//has no details:
						htmlWithoutDetails += htmlAuditResult;
					}
				}
			}
		}
		jQuery('.'+thePageClass+' .Audits').html( htmlWithoutDetails + htmlWithDetails );
	}

	function render()
	{
		var result = '';
		result += '<div class="'+thePageClass.toLowerCase()+'">';
		result += '<h1>'+thePageName+'</h1>';
		result += '<div class="TheResult"></div>';
		result += '<div class="spinner"><div class="cube1"></div><div class="cube2"></div></div>';
		result += '<div class="Audits"></div>';
		result += '</div>';

		return result;
	}
}


window.pageSpeedWebsites = [];
//array[id] = {url,pid}

jQuery.noConflict();

document.addEventListener('DOMContentLoaded', function()
{
	window.pageSpeedController  = new NNPageSpeedController();
});
