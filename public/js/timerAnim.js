// Copyright (c) 2018 Rolf Michael Bislin. Licensed under the MIT license (see LICENSE.txt). 
function timerAnim(starttime, stoptime) {
	return function timerAnim(p5) {
		let radius = 100;
	
		let sColor, mColor, hColor = null;
		let sFadeColor = null;
		let sFadeFinished = true;

		p5.setup = function() {
			p5.createCanvas(400, 400);
			radius = p5.width;
			
			sColor = p5.color(255,0,0,255);
			sFadeColor = p5.color(255,0,0,0);
			sFadeTarget = p5.color(255,0,0,0);
		
			mColor = p5.color(0,255,0,255);
			hColor = p5.color(0,0,255,255);
			
			p5.strokeCap(p5.SQUARE);
			p5.smooth();
			
			if(typeof stoptime == "undefined") {
				p5.frameRate(24);
			} else {
				p5.noLoop();
			}
		}
	
		p5.draw = function() {
			p5.translate(p5.width/2, p5.height/2);
			p5.rotate(p5.radians(-90));
			
			p5.clear();
		
			p5.noFill();
			p5.strokeWeight(radius*0.1);
			
			let seconds = getSeconds();
			let minutes = p5.floor(seconds/60);
			let hours = p5.floor(minutes/60);
		
			
			if(seconds>=60 && seconds%60<5) {
				if(sFadeFinished && seconds%60<2.5) {
					sFadeFinished=false;
					sFadeColor = p5.lerpColor(sColor,sColor,0.0);
				}
		
				var oldAlpha = p5.alpha(sFadeColor);
				sFadeColor = p5.lerpColor(sFadeColor, sFadeTarget, 0.05);
				
				if(p5.alpha(sFadeColor)==oldAlpha) {
					sFadeColor.setAlpha(0);
				} else {
					p5.stroke(sFadeColor);
					p5.ellipse(0,0,radius*0.9);
				}
			} else {
				sFadeFinished=true;
				sFadeColor.setAlpha(0);
			}
		
			p5.stroke(sColor);
			p5.arc(0,0,radius*0.9,radius*0.9,0,p5.radians(360/60*seconds));
			
			if(minutes>0) {
				p5.stroke(mColor);
				p5.arc(0,0,radius*0.7, radius*0.7, 0, p5.radians(360/60*minutes));
			}
			
			if(hours>0) {
				p5.stroke(hColor);
				p5.arc(0,0,radius*0.5, radius*0.5, 0, p5.radians(360/24*hours));
			}
		}


		function getSeconds() {
			let time;
			if(typeof stoptime == "undefined") {
				d = new Date();
				time = (d.getTime())/1000;
			} else {
				time = stoptime;
			}
			return time-starttime;
		}
	}
}