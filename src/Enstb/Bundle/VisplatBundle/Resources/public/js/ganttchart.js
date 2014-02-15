function createGanttChart(jsonData) {

	var margin = {top: 50, right: 20, bottom: 20, left: 50};

	var w = window.innerWidth,                      	 //width
	h = window.innerHeight;                           	 //height
	
	// CREATION OF GANTT CHART

	// Binding json data from json object instead of reading from file
	tasks = JSON.parse(jsonData);
	
		var reg=new RegExp("(-)", "g");
		var format = d3.time.format("%Y-%m-%d %H:%M:%S");

		tasks.forEach(function(d) {
			d.startDate = new Date(format.parse(d.startDate));
			d.endDate = new Date(format.parse(d.endDate));
			d.taskName = d.taskName.toLowerCase();
			d.taskName = d.taskName.charAt(0).toUpperCase()+d.taskName.substr(1);
			d.taskName = d.taskName.replace(reg, " ");
		});
		

		var taskStatus = {
			"SUCCEEDED" : "bar",
			"FAILED" : "bar-failed",
			"RUNNING" : "bar-running",
			"KILLED" : "bar-killed"
		};

		var taskNames = [ "Brush teeth", "Go to bed", "Use toilet", "Prepare breakfast", "Take shower", "Leave house", "Prepare dinner", "Get drink" ];

		tasks.sort(function(a, b) {
			return a.endDate - b.endDate;
		});
		var maxDate = tasks[tasks.length - 1].endDate;
		tasks.sort(function(a, b) {
			return a.startDate - b.startDate;
		});
		var minDate = tasks[0].startDate;

		var format = "%H:%M";

		var gantt = d3.gantt().taskTypes(taskNames).taskStatus(taskStatus).tickFormat(format);
		gantt(tasks);


};

