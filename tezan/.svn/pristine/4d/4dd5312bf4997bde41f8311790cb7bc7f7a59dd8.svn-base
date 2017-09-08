/**
 * Created by clubs on 2017/5/24.
 */

FlowEditorClass = {
	init: function (parent)
	{
		if(typeof parent == "undefined") return null;

		var Interface = {
			seed: 0,
			svgns: "http://www.w3.org/2000/svg",
			linkns: "http://www.w3.org/1999/xlink",
			vmlns: "urn:schemas-microsoft-com:vml",
			officens: "urn:schemas-microsoft-com:office:office",
			IMAGE_ROOT : "/Public/gef/images/",
			CANVAS_STROKE : "#03689A",
			CANVAS_FILL : "#F5DEB3",
			flowid: "",
			emptyFn: function (){},
			emptyArray: [],
			emptyMap: {},
			installVml: function ()
			{
				if (this.isVml)
				{
					document.attachEvent("onreadystatechange", function ()
					{
						var _ = document;
						if (_.readyState == "complete")
						{
							if (!_.namespaces["v"])
								_.namespaces.add("v", $.vmlns);
							if (!_.namespaces["o"])
								_.namespaces.add("o", $.officens)
						}
					});
					var _     = document.createStyleSheet();
					_.cssText = "v\\:*{behavior:url(#default#VML)}"
								+ "o\\:*{behavior:url(#default#VML)}"
				}
			},
			id: function ()
			{
				if (typeof this.parentid != "undefined" && this.parentid != "")
				{
					return "_" + this.parentid + "_svg_" + this.seed++;
				}
				else
				{
					return "_FLOWDETAILS_SVG_" + this.seed++;
				}
			},
			getInt : function($) {
				$ += "";
				$ = $.replace(/px/, "");
				var _ = parseInt($, 10);
				return isNaN(_) ? 0 : _
			},
			extend : function() {
				var A = function($) {
					for (var _ in $)
						this[_] = $[_]
				}, _ = Object.prototype.constructor;
				return function(F, E, D) {
					if (typeof E == "object") {
						D = E;
						E = F;
						F = D.constructor != _ ? D.constructor : function() {
							E.apply(this, arguments)
						}
					}
					var B = function() {
					}, C, G = E.prototype;
					B.prototype = G;
					C = F.prototype = new B();
					C.constructor = F;
					F.superclass = G;
					if (G.constructor == _)
						G.constructor = E;
					C.override = A;
					Interface.override(F, D);
					return F
				}
			}(),
			override : function(C, _) {
				if (_) {
					var A = C.prototype;
					for (var B in _)
						A[B] = _[B];
					if (Interface.isIE && _.toString != C.toString)
						A.toString = _.toString
				}
			},
			ns : function() {
				for (var E = 0; E < arguments.length; E++) {
					var _ = arguments[E], A = _.split("."),
						C = Interface,
						$ = A.slice(1);
					for (var D = 0; D < $.length; D++) {
						var B = $[D];
						C = C[B] = C[B] || {}
					}
				}
				return C
			},
			apply : function(C, A, _) {
				if (_)
					$.apply(C, _);
				if (C && A && typeof A == "object")
					for (var B in A)
						C[B] = A[B];
				return C
			},
			applyIf : function(A, $) {
				if (A && $)
					for (var _ in $)
						if (typeof A[_] == "undefined")
							A[_] = $[_];
				return A
			},
			join : function(_) {
				var $ = "";
				for (var A = 0; A < _.length; A++)
					$ += _[A];
				return $
			},
			getTextSize : function(A) {
				if (!Interface.textDiv) {
					Interface.textDiv = document.createElement("div");
					Interface.textDiv.style.position = "absolute";
					Interface.textDiv.style.fontFamily = "Verdana";
					Interface.textDiv.style.fontSize = "12px";
					Interface.textDiv.style.left = "-1000px";
					Interface.textDiv.style.top = "-1000px";
					if(typeof Interface.parent != "undefined" && typeof Interface.ViewPort != "undefined"){
						Interface.ViewPort.appendChild(Interface.textDiv)
					}else
					{
						document.body.appendChild(Interface.textDiv)
					}
				}
				var B = Interface.textDiv;
				B.innerHTML = A;
				var _ = {
					w : Math.max(B.offsetWidth, B.clientWidth),
					h : Math.max(B.offsetHeight, B.clientHeight)
				};
				return _
			},
			notBlank : function($) {
				if (typeof $ == "undefined")
					return false;
				else if (typeof $ == "string" && $.trim().length == 0)
					return false;
				return true
			},
			safe : function($) {
				if ($)
					return $.trim();
				else
					return ""
			},
			get : function($) {
				return document.getElementById($)
			},
			value : function(_, B) {
				var A = $.get(_);
				if (typeof B != "undefined")
					A.value = $.safe(B);
				return $.safe(A.value)
			},
			each : function(C, A, $) {
				if (typeof C.length == "undefined" || typeof C == "string")
					C = [C];
				for (var B = 0, _ = C.length; B < _; B++)
					if (A.call($ || C[B], C[B], B, C) == false)
						return B
			},
			isArray : function(v) {
				return v && typeof v.length == "number" && typeof v.splice == "function"
			},
		};
		Interface.parent   = parent;
		Interface.EditorPanelClass = EditorPanelClass.init(parent);

		if (typeof parent.id != "undefined" && parent.id != "")
		{
			Interface.parentid = parent.id;
		}else{
			Interface.parentid = "FlowEditor";
		}

		if (typeof Interface.ShowMode == "undefined") {
			Interface.ShowMode = {
				MODE_EDIT: "mode_edit",
				MODE_READONLY: "mode_readonly",
				MODE_STEP: "mode_step",
			};
		}

		if (typeof Interface.EventMode == "undefined") {
			Interface.EventMode = {
				Alert : Interface.parentid.toUpperCase() + ".EventType.Alert",
				Info  : Interface.parentid.toUpperCase() + ".EventType.Info",
				Dialog : Interface.parentid.toUpperCase() + ".EventType.Dialog",
				DialogScreenTransition : Interface.parentid.toUpperCase() + ".EventType.Dialog.Screen.Transition",		//边Screen设置
				DialogScreenNode : Interface.parentid.toUpperCase() + ".EventType.Dialog.Screen.Node",					//节点Screen设置
				DialogPermission : Interface.parentid.toUpperCase() + ".EventType.Dialog.Permission",					//节点权限设置
				DialogTrend : Interface.parentid.toUpperCase() + ".EventType.Dialog.Trend",								//节点分支条件
				DialogTimer : Interface.parentid.toUpperCase() + ".EventType.Dialog.Timer",								//节点定时器设置
				DialogTask : Interface.parentid.toUpperCase() + ".EventType.Dialog.Task",								//节点任务设置
				DialogJoin : Interface.parentid.toUpperCase() + ".EventType.Dialog.Join",								//节点汇聚条件设置
				DialogSign : Interface.parentid.toUpperCase() + ".EventType.Dialog.Sign",								//节点会签属性设置
				DialogSubProcess : Interface.parentid.toUpperCase() + ".EventType.Dialog.SubProcess",					//节点设置子流程
				DialogViewSubProcess : Interface.parentid.toUpperCase() + ".EventType.Dialog.ViewSubProcess",			//查看子流程
				ChangeNodeName : Interface.parentid.toUpperCase() + ".EventType.ChangeNodeName",							//节点名修改
				ChangeTransitionName : Interface.parentid.toUpperCase() + ".EventType.ChangeTransitionName",				//出边名修改
				RemoveTransition : Interface.parentid.toUpperCase() + ".EventType.RemoveTransition",						//出边删除
				RemoveNode : Interface.parentid.toUpperCase() + ".EventType.RemoveNode",									//节点删除
				// GetProcessParameterByNames : Interface.parentid.toUpperCase() + ".EventType.GetProcessParameterByNames",	//获取节点汇聚参数
				CreateNode : Interface.parentid.toUpperCase() + ".EventType.CreateNode",									//创建节点
				CreateTransition : Interface.parentid.toUpperCase() + ".EventType.CreateTransition",						//创建出边
			};
		}

		(function() {
			var F = navigator.userAgent.toLowerCase(),
				E = F.indexOf("opera") > -1,
				B = (/webkit|khtml/).test(F),
				H = !E && F.indexOf("msie") > -1,
				_ = !E && F.indexOf("msie 7") > -1,
				A = !E && F.indexOf("msie 8") > -1,
				D = !B && F.indexOf("gecko") > -1,
				C = H || _ || A,
				G = !C;
			Interface.isSafari = B;
			Interface.isIE = H;
			Interface.isIE7 = _;
			Interface.isGecko = D;
			Interface.isVml = C;
			Interface.isSvg = G;
			if (C)
				Interface.installVml();
			Interface.applyIf(Array.prototype, {
				indexOf : function($) {
					for (var A = 0, _ = this.length; A < _; A++)
						if (this[A] == $)
							return A;
					return -1
				},
				remove : function(_) {
					var $ = this.indexOf(_);
					if ($ != -1)
						this.splice($, 1);
					return this
				}
			});
			String.prototype.trim = function() {
				var $ = /^\s+|\s+$/g;
				return function() {
					return this.replace($, "")
				}
			}()
		})();

		this.initGeom(Interface);
		this.initEvent(Interface);
		this.initUIBase(Interface);
		this.initUISupport(Interface);
		this.initCommands(Interface);
		this.initEditor(Interface);
		this.initEditorCom(Interface);
		this.initXML(Interface);
		this.initEditorSupport(Interface);
		this.initEditorModel(Interface);
		this.initTracker(Interface);
		this.initEditorPort(Interface);
		this.initFigure(Interface);
		this.initSimple(Interface);
		this.initPanel(Interface);
		this.initEditorPara(Interface);

		Interface.initEditor = function(xmlString){
			var id = Interface.parentid + "_ViewPort_";
			if(Interface.EditorPanelClass.getCmp(id)){
				Interface.EditorPanelClass.getCmp(id).destroy();
			}
			var PanelItems = [];
			if(Interface.Editor.ShowMode == Interface.ShowMode.MODE_EDIT){
				PanelItems.push(Interface.Editor.createWest());
			}
			PanelItems.push(Interface.Editor.createCenter());
			var $ = new  Interface.EditorPanelClass.Panel({
									   id : id,
									   layout : 'border',
									   border : false,
									   height : Interface.parent.offsetHeight,
									   region : 'center',
									   renderTo: Interface.parentid,
									   monitorResize : true,
									   items  : PanelItems
								   })
			Interface.ViewPort = Interface.EditorPanelClass.getDom(id);
			var A = new Interface.simple.ExtEditor(),
				_ = new Interface.simple.SimpleEditorInput(),
				B = new Interface.ui.support.DefaultWorkbenchWindow();
			if (null != xmlString && 'null' != xmlString && '' != xmlString)
				_.readXml(xmlString)
			B.getActivePage().openEditor(A, _);
			B.render(Interface.parent);
			if(Interface.Editor.ShowMode == Interface.ShowMode.MODE_READONLY)
			{
				A.disable();
			}
			Interface.activeEditor = A;
			Interface.workbenchWindow = B;
		};

		Interface.Destroy = function(){
			var id = Interface.parentid + "_ViewPort_";
			if(Interface.EditorPanelClass.getCmp(id)){
				Interface.activeEditor.disable();
				Interface.EditorPanelClass.getCmp(id).destroy();
				Interface.textDiv = null;
			}
		};

		return Interface;
	},

	initGeom : function(Interface) {
		Interface.ns("Interface.Geom");
		Interface.Geom = {
			Point: Interface.extend(Object, {
				constructor: function (_, $)
				{
					this.x = _;
					this.y = $
				}
			}),
			Line : Interface.extend(Object, {
				constructor : function(B, $, A, _) {
					this.x1 = B;
					this.y1 = $;
					this.x2 = A;
					this.y2 = _
				},
				getX1 : function() {
					return this.x1;
				},
				getX2 : function() {
					return this.x2;
				},
				getY1 : function() {
					return this.y1;
				},
				getY2 : function() {
					return this.y2;
				},
				getK : function() {
					return (this.y2 - this.y1) / (this.x2 - this.x1)
				},
				getD : function() {
					return this.y1 - this.getK() * this.x1
				},
				isParallel : function($) {
					var A = this.x1, _ = this.x2;
					if ((Math.abs(A - _) < 0.01) && (Math.abs($.getX1() - $.getX2()) < 0.01))
						return true;
					else if ((Math.abs(A - _) < 0.01)
							 && (Math.abs($.getX1() - $.getX2()) > 0.01))
						return false;
					else if ((Math.abs(A - _) > 0.01)
							 && (Math.abs($.getX1() - $.getX2()) < 0.01))
						return false;
					else
						return Math.abs(this.getK() - $.getK()) < 0.01
				},
				isSameLine : function(_) {
					if (this.isParallel(_)) {
						var A = _.getK(), $ = _.getD();
						if (Math.abs(this.x1 * A + $ - this.y1) < 0.01)
							return true;
						else
							return false
					} else
						return false
				},
				contains : function(B) {
					var H = this.x1, C = this.y1, E = this.x2, D = this.y2,
						G = B.x, F = B.y,
						A = (H - E) * (H - E) + (C - D) * (C - D),
						_ = (G - H) * (G - H) + (F - C) * (F - C),
						$ = (G - E) * (G - E) + (F - D) * (F - D);
					return A > _ && A > $
				},
				getCrossPoint : function(B) {
					if (this.isParallel(B))
						return null;
					var F, D;
					if (Math.abs(this.x1 - this.x2) < 0.01) {
						F = this.x1;
						D = B.getK() * F + B.getD()
					} else if (Math.abs(B.getX1() - B.getX2()) < 0.01) {
						F = B.getX1();
						D = this.getD()
					} else {
						var C = this.getK(), E = B.getK(), $ = this.getD(), _ = B.getD();
						F = (_ - $) / (C - E);
						D = C * F + $;
					}
					var A = new Interface.Geom.Point(F, D);
					if (B.contains(A) && this.contains(A))
						return A;
					else
						return null
				},
			}),
			Rect : Interface.extend(Object, {
				constructor : function(B, A, $, _) {
					this.x = B;
					this.y = A;
					this.w = $;
					this.h = _
				},
				getCrossPoint : function(A) {
					var $ = null, D = new Interface.Geom.Line(this.x, this.y, this.x + this.w, this.y);
					$ = D.getCrossPoint(A);
					if ($ != null)
						return $;
					var B = new Interface.Geom.Line(this.x, this.y, this.x, this.y + this.h);
					$ = B.getCrossPoint(A);
					if ($ != null)
						return $;
					var _ = new Interface.Geom.Line(this.x, this.y + this.h, this.x + this.w, this.y + this.h);
					$ = _.getCrossPoint(A);
					if ($ != null)
						return $;
					var C = new Interface.Geom.Line(this.x + this.w, this.y, this.x + this.w, this.y + this.h);
					$ = C.getCrossPoint(A);
					if ($ != null)
						return $;
					var E = new Interface.Geom.Line(this.x + this.w, this.y, this.x, this.y + this.h);
					$ = E.getCrossPoint(A);
					return $;
				}
			})
		}
	},
	//初始化外部事件接口
	initEvent : function(Interface) {
		Interface.ns("Interface.Event");
		Interface.Event = {
			__events : {},
			_indexOf : function(array,obj){
				if (array == null) return -1
				var i = 0, length = array.length
				for (; i < length; i++) if (array[i] == obj) return i
				return -1
			},

			on: function (key, listener)
			{
				if (!this.__events)
				{
					this.__events = {}
				}
				if (!this.__events[key])
				{
					this.__events[key] = []
				}
				if (this._indexOf(this.__events, listener) == -1 && typeof listener == 'function')
				{
					this.__events[key].push(listener)
				}
			},
			off: function (key, listener)
			{
				if (!key && !listener)
				{
					this.__events = {}
				}
				//不传监听函数，就去掉当前key下面的所有的监听函数
				if (key && !listener)
				{
					delete this.__events[key]
				}

				if (key && listener)
				{
					var listeners = this.__events[key]
					var idx       = this._indexOf(listeners, listener)
					if (idx > -1) listeners.splice(idx, 1)
				}
			},
			trigger: function (key)
			{
				if (!this.__events || !this.__events[key]) return

				var args = Array.prototype.slice.call(arguments, 1) || []

				var listeners = this.__events[key]
				var i         = 0
				var l         = listeners.length

				for (i; i < l; i++)
				{
					listeners[i].apply(this, args)
				}
			}
		};
	},
	//初始化图型界面的基类
	initUIBase : function(Interface) {
		Interface.ns("Interface.ui");
		Interface.ui.WorkbenchWindow = Interface.extend(Object, {
			getActivePage : Interface.emptyFn
		});
		Interface.ui.WorkbenchPage = Interface.extend(Object, {
			getWorkbenchWindow : Interface.emptyFn,
			getActiveEditor : Interface.emptyFn,
			openEditor : Interface.emptyFn
		});
		Interface.ui.WorkbenchPart = Interface.extend(Object, {
			setWorkbenchPage : Interface.emptyFn,
			getWorkbenchPage : Interface.emptyFn
		});
		Interface.ui.ViewPart = Interface.extend(Object, {});
		Interface.ui.EditorPart = Interface.extend(Interface.ui.WorkbenchPart, {
			init : Interface.emptyFn
		});
		Interface.ui.EditorInput = Interface.extend(Object, {
			getName : Interface.emptyFn,
			getObject : Interface.emptyFn
		});
	},
	//初始化图型界面支持类
	initUISupport : function(Interface) {
		Interface.ns("Interface.ui.support");
		Interface.ui.support.DefaultWorkbenchWindow = Interface.extend(Interface.ui.WorkbenchWindow, {
			getActivePage : function() {
				if (!this.activePage) {
					this.activePage = new Interface.ui.support.DefaultWorkbenchPage();
					this.activePage.setWorkbenchWindow(this)
				}
				return this.activePage
			},
			render : function(Interface) {
				if (!this.rendered) {
					if(Interface){
						this.width = Interface.offsetWidth;
						this.height = Interface.offsetHeight;
					}else
					{
						document.getElementsByTagName("html")[0].className += " Interface-workbenchwindow";
						if (Interface.isIE)
						{
							this.width  = document.body.offsetWidth;
							this.height = document.body.offsetHeight
						}
						else
						{
							this.width  = window.innerWidth;
							this.height = window.innerHeight
						}
					}
					this.getActivePage().render();
					this.rendered = true
				}
			}
		});
		Interface.ui.support.DefaultWorkbenchPage = Interface.extend(Interface.ui.WorkbenchPage, {
			constructor : function($) {
				this.workbenchWindow = $
			},
			getWorkbenchWindow : function() {
				return this.workbenchWindow
			},
			setWorkbenchWindow : function($) {
				this.workbenchWindow = $
			},
			getActiveEditor : function() {
				return this.activeEditor
			},
			openEditor : function(extEditor, editorInput) {
				this.activeEditor = extEditor;
				extEditor.setWorkbenchPage(this);
				extEditor.init(editorInput)
			},
			render : function() {
				this.activeEditor.render()
			}
		});
		Interface.ui.support.DefaultEditorPart = Interface.extend(Interface.ui.EditorPart, {
			constructor : function($) {
				this.workbenchPage = $
			},
			getWorkbenchPage : function() {
				return this.workbenchPage
			},
			setWorkbenchPage : function($) {
				this.workbenchPage = $
			},
			init : function($) {
			},
			render : function() {
			}
		});
	},
	//初始化图型界面命令类
	initCommands : function(Interface) {
		Interface.ns("Interface.commands");
		Interface.commands.Command = Interface.extend(Object, {
			execute : Interface.emptyFn,
			undo : Interface.emptyFn,
			redo : Interface.emptyFn
		});
		Interface.commands.CommandStack = Interface.extend(Object, {
			constructor : function() {
				this.undoList = [];
				this.redoList = [];
				this.maxUndoLength = 100
			},
			execute : function($) {
				while (this.undoList.length > this.maxUndoLength)
					this.undoList.shift();
				this.undoList.push($);
				this.redoList.splice(0, this.redoList.length);
				$.execute();
				return $
			},
			redo : function() {
				var $ = this.redoList.pop();
				if ($ != null) {
					this.undoList.push($);
					$.redo();
					return this.redoList.length > 0
				}
				return false
			},
			undo : function() {
				var $ = this.undoList.pop();
				if ($ != null) {
					while (this.redoList.length > this.maxUndoLength)
						this.redoList.shift();
					this.redoList.push($);
					$.undo();
					return this.undoList.length > 0
				}
				return false
			},
			flush : function() {
				this.flushUndo();
				this.flushRedo()
			},
			flushUndo : function() {
				this.undoList.splice(0, this.undoList.length)
			},
			flushRedo : function() {
				this.redoList.splice(0, this.redoList.length)
			},
			getMaxUndoLength : function() {
				return this.maxUndoLength
			},
			setMaxUndoLength : function($) {
				this.maxUndoLength = $
			},
			canUndo : function() {
				return this.undoList.length > 0
			},
			canRedo : function() {
				return this.redoList.length > 0
			}
		});
		Interface.commands.CompoundCommand = Interface.extend(Interface.commands.Command, {
			constructor : function() {
				this.commandList = []
			},
			addCommand : function($) {
				this.commandList.push($)
			},
			getCommandList : function() {
				return this.commandList
			},
			execute : function() {
				for (var $ = 0; $ < this.commandList.length; $++)
					this.commandList[$].execute()
			},
			undo : function() {
				for (var $ = this.commandList.length - 1; $ >= 0; $--)
					this.commandList[$].undo()
			},
			redo : function() {
				for (var $ = 0; $ < this.commandList.length; $++)
					this.commandList[$].redo()
			}
		});
	},
	//初始化编辑器基类
	initEditor : function(Interface) {
		Interface.ns("Interface.gef");
		Interface.gef.Editor = Interface.extend(Interface.ui.EditorPart, {
			getEditDomain : Interface.emptyFn,
			getGraphicalViewer : Interface.emptyFn,
			getModelFactory : Interface.emptyFn,
			setModelFactory : Interface.emptyFn,
			getEditPartFactory : Interface.emptyFn,
			setEditPartFactory : Interface.emptyFn
		});
		Interface.gef.EditPartFactory = Interface.extend(Object, {
			createEditPart : Interface.emptyFn
		});
		Interface.gef.ModelFactory = Interface.extend(Object, {
			createModel : Interface.emptyFn
		});
		Interface.gef.EditDomain = Interface.extend(Object, {
			constructor : function() {
				this.commandStack = new Interface.commands.CommandStack();
				this.editPartRegistry = {};
				this.model2EditPart = {};
				this.figure2EditPart = {}
			},
			getCommandStack : function() {
				return this.commandStack
			},
			setEditor : function($) {
				this.editor = $
			},
			createEditPart : function(_) {
				var $ = _.getId(), A = _.getType(), B = this.editor.getEditPartFactory().createEditPart(A);
				this.editPartRegistry[$] = B;
				B.setModel(_);
				this.registerModel(B);
				return B
			},
			findOrCreateEditPart : function(_) {
				var $ = _.getId(), A = _.getType(), B = this.editPartRegistry[$];
				if (!B)
					B = this.createEditPart(_);
				return B
			},
			registerModel : function(A) {
				var _ = A.getModel(), $ = _.getId();
				if (this.model2EditPart[$] != null)
					this.model2EditPart[$] = A
			},
			findModelByEditPart : function(_) {
				var $ = _.getId();
				return this.model2EditPart[$]
			},
			removeModelByEditPart : function(A) {
				var _ = A.getModel(), $ = _.getId();
				if (this.model2EditPart[$] != null) {
					this.model2EditPart[$] = null;
					delete this.model2EditPart[$]
				}
			},
			registerFigure : function(_) {
				var $ = _.getFigure(), A = $.getId();
				if (this.figure2EditPart[A] != null)
					this.figure2EditPart[A] = _
			},
			findFigureByEditPart : function($) {
				var _ = $.getId();
				return this.figure2EditPart[_]
			},
			removeFigureByEditPart : function(_) {
				var $ = _.getFigure(), A = $.getId();
				if (this.figure2EditPart[A] != null) {
					this.figure2EditPart[A] = null;
					delete this.figure2EditPart[A]
				}
			}
		});
		Interface.gef.EditPartViewer = Interface.extend(Object, {
			getContents : Interface.emptyFn,
			setContents : Interface.emptyFn,
			getRootEditPart : Interface.emptyFn,
			setRootEditPart : Interface.emptyFn,
			getEditDomain : Interface.emptyFn,
			setEditDomain : Interface.emptyFn
		});
		Interface.gef.GraphicalViewer = Interface.extend(Interface.gef.EditPartViewer, {});
		Interface.gef.EditPart = Interface.extend(Object, {
			getModel : Interface.emptyFn,
			getFigure : Interface.emptyFn
		});
		Interface.gef.RootEditPart = Interface.extend(Interface.gef.EditPart, {
			getContents : Interface.emptyFn,
			setContents : Interface.emptyFn,
			getViewer : Interface.emptyFn,
			setViewer : Interface.emptyFn
		});

		Interface.ns("Interface.gef.editparts");
		Interface.gef.editparts.AbstractEditPart = Interface.extend(Interface.gef.EditPart, {
			constructor : function() {
				this.children = []
			},
			getParent : function() {
				return this.parent
			},
			setParent : function($) {
				this.parent = $
			},
			getRoot : function() {
				return this.getParent().getRoot()
			},
			getChildren : function() {
				return this.children
			},
			setChildren : function($) {
				this.children = $
			},
			addChild : function($) {
				this.children.push($);
				$.setParent(this);
				this.addChildVisual($)
			},
			removeChild : function($) {
				this.removeChildVisual($);
				$.setParent(null);
				this.children.remove($)
			},
			addChildVisual : Interface.emptyFn,
			removeChildVisual : Interface.emptyFn,
			createChild : function($) {
				var _ = this.createEditPart($);
				return _
			},
			findOrCreateConnection : function($) {
				var _ = this.findOrCreateEditPart($);
				_.setSource($.getSource().getEditPart());
				_.setTarget($.getTarget().getEditPart());
				_.setParent(this.getRoot());
				this.addChildVisual(_);
				return _
			},
			createEditPart : function($) {
				return this.getViewer().editor.getEditDomain().createEditPart($)
			},
			findOrCreateEditPart : function($) {
				return this.getViewer().editor.getEditDomain().findOrCreateEditPart($)
			},
			getFigure : function() {
				if (this.figure == null || this.figure == undefined)
					this.figure = this.createFigure();
				return this.figure
			},
			createFigure : Interface.emptyFn,
			getModel : function() {
				return this.model
			},
			setModel : function($) {
				this.model = $;
				$.setEditPart(this);
				$.addChangeListener(this)
			},
			getModelChildren : function() {
				return this.model != null && this.model.children != null ? this.model.children : Interface.emptyArray
			},
			getCommand : Interface.emptyFn,
			refresh : function() {
				this.refreshVisuals();
				this.refreshChildren()
			},
			refreshVisuals : Interface.emptyFn,
			refreshChildren : function() {
				var A = {};
				for (var C = 0; C < this.getChildren().length; C++) {
					var $ = this.getChildren()[C];
					A[$.getModel().getId()] = $
				}
				for (C = 0; C < this.getModelChildren().length; C++) {
					var _ = this.getModelChildren()[C], B = A[_.getId()];
					if (B == null || B == undefined) {
						B = this.createChild(_);
						this.addChild(B)
					}
					B.refresh()
				}
			},
			getViewer : function() {
				return this.getRoot().getViewer()
			}
		});
		Interface.gef.editparts.AbstractGraphicalEditPart = Interface.extend(Interface.gef.editparts.AbstractEditPart, {
			addChildVisual : function(_) {
				if (_.getClass() == "node") {
					var $ = _.getFigure();
					this.getRoot().getFigure().addNode($);
					$.render()
				} else if (_.getClass() == "connection")
					if (_.getSource() != null && _.getTarget() != null) {
						$ = _.getFigure();
						if (!$.el) {
							this.getRoot().getFigure().addConnection($);
							$.render()
						}
					}
			},
			removeChildVisual : function(_) {
				var $ = _.getFigure();
				this.getFigure().removeChild($)
			},
			refresh : function() {
				Interface.gef.editparts.AbstractGraphicalEditPart.superclass.refresh.call(this);
				this.refreshSourceConnections();
				this.refreshTargetConnections()
			},
			refreshSourceConnections : function() {
				var A = {};
				for (var C = 0; C < this.getSourceConnections().length; C++) {
					var $ = this.getSourceConnections()[C];
					A[$.getModel().getId()] = $
				}

				for (C = 0; C < this.getModelSourceConnections().length; C++) {
					var _ = this.getModelSourceConnections()[C], B = A[_.getId()];
					if (B == null) {
						B = this.findOrCreateConnection(_);
						this.addSourceConnection(B)
					} else
						B.refresh()
				}
			},
			refreshTargetConnections : function() {
				var A = {};
				for (var C = 0; C < this.getTargetConnections().length; C++) {
					var $ = this.getTargetConnections()[C];
					A[$.getModel().getId()] = $
				}
				for (C = 0; C < this.getModelTargetConnections().length; C++) {
					var _ = this.getModelTargetConnections()[C], B = A[_.getId()];
					if (B == null) {
						B = this.findOrCreateConnection(_);
						this.addTargetConnection(B)
					} else
						B.refresh()
				}
			},
			addSourceConnection : function($) {
				this.getSourceConnections().push($)
			},
			addTargetConnection : function($) {
				this.getTargetConnections().push($)
			},
			notifyChanged : function(C, D) {
				if (C == "CHILD_ADDED") {
					var A = D, B = this.createChild(A);
					this.addChild(B);
					A.parent = this.model;
					B.parent = this
				} else if (C == "CHILD_REMOVED_FROM_PARENT") {
					if(this.parent != null)
					{
						this.parent.removeChild(this);
					}
					this.model.removeChangeListener(this)
				} else if (C == "NODE_MOVED")
					this.refresh();
				else if (C == "CONNECTION_SOURCE_ADDED")
					this.refresh();
				else if (C == "CONNECTION_TARGET_ADDED")
					this.refresh();
				else if (C == "NODE_RESIZED")
					this.refresh();
				else if (C == "CONNECTION_RESIZED") {
					this.getFigure().innerPoints = this.getModel().innerPoints;
					this.getFigure().modify()
				} else if (C == "TEXT_POSITION_UPDATED") {
					this.getFigure().textX = this.getModel().textX;
					this.getFigure().textY = this.getModel().textY;
					this.getFigure().modify()
				} else if (C == "TEXT_UPDATED") {
					var $ = this.getModel().text, _ = this.getFigure();
					if (typeof _.updateAndShowText != "undefined")
						_.updateAndShowText($)
				} else if (C == "CONNECTION_TEXT_UPDATED") {
					var $ = this.getModel().text, _ = this.getFigure();
					_.updateAndShowText($)
				} else if (C == "RECONNECTED") {
					this.setSource(this.getModel().getSource().getEditPart());
					this.setTarget(this.getModel().getTarget().getEditPart());
					_ = this.getFigure();
					_.from = this.getSource().getFigure();
					_.to = this.getTarget().getFigure();
					if (!_.el) {
						this.getRoot().getFigure().addConnection(_);
						_.render()
					}
					_.refresh()
				} else if (C == "DISCONNECTED") {
					this.getSource().removeSourceConnection(this);
					this.getTarget().removeTargetConnection(this);
					this.getFigure().remove();
					this.figure = null
				}
			},
			getCommand : function($) {
				switch ($.role.name) {
					case "CREATE_NODE" :
						return this.getCreateNodeCommand($);
					case "CREATE_EDGE" :
						return this.getCreateConnectionCommand($);
					case "MOVE_NODE" :
						return this.getMoveNodeCommand($);
					case "MOVE_EDGE" :
						return this.getMoveConnectionCommand($);
					case "RESIZE_NODE" :
						return this.getResizeNodeCommand($);
					case "RESIZE_EDGE" :
						return this.getResizeConnectionCommand($);
					case "MOVE_TEXT" :
						return this.getMoveTextCommand($);
					case "EDIT_TEXT" :
						return this.getEditTextCommand($);
					case "REMOVE_EDGE" :
						return this.getRemoveConnectionCommand($);
					case "REMOVE_NODES" :
						return this.getRemoveNodesCommand($);
					default :
						return null
				}
			},
			getCreateNodeCommand : function(A) {
				var _ = A.role.node, $ = this.getModel(), B = A.role.rect;
				if (!this.canCreate(_))
					return null;
				return new Interface.gef.command.CreateNodeCommand(_, $, B)
			},
			canCreate : function() {
				return true
			},
			getCreateConnectionCommand : function(B) {
				var A = B.role.source, $ = B.role.target, _ = B.role.model;
				if (this.isDuplicated(_, A, $))
					return null;
				if('sign'==A.type){//会签节点
					var signConnections = A.getSourceConnections();
					if(null != signConnections && signConnections.length>1){//会签节点有大于2的出边
						Interface.Event.trigger(Interface.EventMode.Alert,"会签节点只能有同意否决两条出边！")
						return null;
					}
				}
				return new Interface.gef.command.CreateConnectionCommand(_, A, $)
			},
			canCreateOutgo : function() {
				return true
			},
			canCreateIncome : function() {
				return true
			},
			isDuplicated : function(A, B, _) {
				var $ = false;
				Interface.each(B.getSourceConnections(), function(A) {
					if (A.getTarget() == _) {
						Interface.Event.trigger(Interface.EventMode.Alert,"相同的方向，两个节点之间只能有一条路径。")
						$ = true;
						return false
					}
				});
				return $
			},
			isTextConflict : function(event){//判断名称是否重复
				var newValue = event.role.text;
				var oldValue = this.model.text;
				var type = this.model.type;
				var i=0;
				if("transition"==type){//同一节点上的出边是不能重复的
					var otherOuterNames = [];
					var outComes = this.source.sourceConnections;
					for(i=0;i<outComes.length;i++){
						if(outComes[i].model.text != oldValue)
							otherOuterNames.push(outComes[i].model.text);
					}
					for(i=0;i<otherOuterNames.length;i++){
						if(otherOuterNames[i]==newValue){
							if(event.eventName=="MOUSE_DOWN")
								Interface.Event.trigger(Interface.EventMode.Alert,"同一个节点的出边不能重名！")
							return true;
						}
					}
				}else{
					var otherNodeNames = [];
					var allNodes = this.parent.children;
					for(i=0;i<allNodes.length;i++){
						if(allNodes[i].model.text!=oldValue)
							otherNodeNames.push(allNodes[i].model.text);
					}
					for(i=0;i<otherNodeNames.length;i++){
						if(otherNodeNames[i]==newValue){
							if(event.eventName=="MOUSE_DOWN")
								Interface.Event.trigger(Interface.EventMode.Alert,"该节点名已经存在，请重新输入！")
							return true;
						}
					}
				}
				return false;
			},
			getMoveNodeCommand : function(A) {
				var $ = A.role.dx, _ = A.role.dy;
				return new Interface.gef.command.MoveAllCommand(A.role.nodes, $, _)
			},
			getMoveConnectionCommand : function(B) {
				var A = B.role.source, $ = B.role.target, _ = this.getModel();
				if (this.isDuplicated(_, A, $))
					return null;
				if('sign'==A.type){//会签节点
					var signConnections = A.getSourceConnections();
					if(null != signConnections && signConnections.length>1){//会签节点有大于2的出边
						Interface.Event.trigger(Interface.EventMode.Alert,"会签节点只能有同意否决两条出边！")
						return null;
					}
				}
				return new Interface.gef.command.MoveConnectionCommand(_, A, $)
			},
			getResizeNodeCommand : function(_) {
				var $ = this.getModel(), A = _.role.rect;
				return new Interface.gef.command.ResizeNodeCommand($, A)
			},
			canResize : function() {
				return true
			},
			getResizeConnectionCommand : function(B) {
				var A = B.role.oldInnerPoints, _ = B.role.newInnerPoints, $ = this.getModel();
				return new Interface.gef.command.ResizeConnectionCommand($, A, _)
			},
			getMoveTextCommand : function(B) {
				var _ = this.getModel(), D = B.role.oldTextX, C = B.role.oldTextY, A = B.role.newTextX, $ = B.role.newTextY;
				return new Interface.gef.command.MoveTextCommand(_, D, C, A, $)
			},
			getEditTextCommand : function(A) {
				if(this.isTextConflict(A))
					return null;
				var _ = this.getModel(), $ = A.role.text;
				return new Interface.gef.command.EditTextCommand(_, $)
			},
			getRemoveConnectionCommand : function(_) {
				var $ = this.getModel();
				return new Interface.gef.command.RemoveConnectionCommand($)
			},
			getRemoveNodesCommand : function(A) {
				var B = new Interface.commands.CompoundCommand();
				try {
					var _ = [];
					Interface.each(A.role.nodes, function($) {
						Interface.each($.getSourceConnections(), function($) {
							if (_.indexOf($) == -1)
								_.push($)
						});
						Interface.each($.getTargetConnections(), function($) {
							if (_.indexOf($) == -1)
								_.push($)
						})
					});
					Interface.each(_, function($) {
						B.addCommand(new Interface.gef.command.RemoveConnectionCommand($.getModel()))
					});
					Interface.each(A.role.nodes, function($) {
						B.addCommand(new Interface.gef.command.RemoveNodeCommand($.getModel()))
					})
				} catch ($) {
					console.info($)
				}
				return B
			}
		});
		Interface.gef.editparts.AbstractRootEditPart = Interface.extend(Interface.gef.RootEditPart, {
			getFigure : function() {
				if (!this.figure)
					this.figure = this.createFigure();
				return this.figure
			},
			createFigure : function() {
				var $ = new Interface.figure.GraphicalViewport();
				return $
			},
			getContents : function() {
				return this.contents
			},
			setContents : function($) {
				this.contents = $;
				$.setParent(this)
			},
			getViewer : function() {
				return this.viewer
			},
			setViewer : function($) {
				this.viewer = $
			},
			getRoot : function() {
				return this
			}
		});
		Interface.gef.editparts.ConnectionEditPart = Interface.extend(Interface.gef.editparts.AbstractGraphicalEditPart, {
			getClass : function() {
				return "connection"
			},
			getSource : function() {
				return this.source
			},
			setSource : function($) {
				this.source = $
			},
			getTarget : function() {
				return this.target
			},
			setTarget : function($) {
				this.target = $
			},
			refresh : function() {
				this.refreshVisuals()
			},
			refreshVisuals : function() {
				var $ = this.getModel().getSource(),
					_ = this.getModel().getTarget();
				if ($ != null && _ != null)
					this.getFigure().refresh();
				else
					this.getFigure().update(0, 0, 0, 0)
			},
			notifyChanged : function(_, A) {
				if (_ == "CONDITION_CHANGED") {
					var $ = this.getFigure();
					if (typeof A == "string" && A != null && A != "") {
						$.setConditional(true);
						$.updateAndShowText(A)
					} else
						$.setConditional(false)
				} else
					Interface.gef.editparts.ConnectionEditPart.superclass.notifyChanged.call(this, _, A)
			}
		});
		Interface.gef.editparts.NodeEditPart = Interface.extend(Interface.gef.editparts.AbstractGraphicalEditPart, {
			getClass : function() {
				return "node"
			},
			getSourceConnections : function() {
				if (!this.sourceConnections)
					this.sourceConnections = [];
				return this.sourceConnections
			},
			getModelSourceConnections : function() {
				return this.getModel().getSourceConnections()
			},
			removeSourceConnection : function($) {
				if ($.getSource() == this)
					this.getSourceConnections().remove($)
			},
			getTargetConnections : function() {
				if (!this.targetConnections)
					this.targetConnections = [];
				return this.targetConnections
			},
			getModelTargetConnections : function() {
				return this.getModel().getTargetConnections()
			},
			removeTargetConnection : function($) {
				if ($.getTarget() == this)
					this.getTargetConnections().remove($)
			},
			refreshVisuals : function() {
				var $ = this.getModel(), _ = this.getFigure();
				_.update($.x, $.y, $.w, $.h)
			}
		});
	},
	//初始化编辑器操作事件
	initEditorCom : function(Interface) {
		Interface.ns("Interface.gef.command");
		Interface.gef.command.CreateNodeCommand = Interface.extend(Interface.commands.Command, {
			constructor : function(_, $, A) {
				this.childNode = _;
				this.parentNode = $;
				this.rect = A
			},
			execute : function() {
				this.childNode.x = this.rect.x;
				this.childNode.y = this.rect.y;
				this.childNode.w = this.rect.w;
				this.childNode.h = this.rect.h;
				this.redo();
				var CurrentNode = this.childNode;
				Interface.Event.trigger(Interface.EventMode.CreateNode,this.childNode.type,this.childNode.text,function(record){
					if(typeof record != "undefined" && record != ""){
						CurrentNode.key = record;
					}
				});
			},
			redo : function() {
				this.parentNode.addChild(this.childNode)
			},
			undo : function() {
				this.parentNode.removeChild(this.childNode)
			}
		});
		Interface.gef.command.CreateConnectionCommand = Interface.extend(Interface.commands.Command, {
			constructor : function(_, A, $) {
				this.connection = _;
				this.sourceNode = A;
				this.targetNode = $
			},
			execute : function() {
				this.connection.setSource(this.sourceNode);
				this.connection.setTarget(this.targetNode);
				this.redo()
				Interface.Event.trigger(Interface.EventMode.CreateTransition,this.sourceNode.key,this.targetNode.key,this.connection.text)
			},
			redo : function() {
				this.connection.reconnect()
			},
			undo : function() {
				this.connection.disconnect()
			}
		});
		Interface.gef.command.MoveNodeCommand = Interface.extend(Interface.commands.Command, {
			constructor : function($, _) {
				this.node = $;
				this.rect = _
			},
			execute : function() {
				this.oldX = this.node.x;
				this.oldY = this.node.y;
				this.newX = this.rect.x;
				this.newY = this.rect.y;
				this.redo()
			},
			redo : function() {
				this.node.moveTo(this.newX, this.newY)
			},
			undo : function() {
				this.node.moveTo(this.oldX, this.oldY)
			}
		});
		Interface.gef.command.MoveConnectionCommand = Interface.extend(Interface.commands.Command, {
			constructor : function(_, A, $) {
				this.connection = _;
				this.sourceNode = A;
				this.targetNode = $
			},
			execute : function() {
				this.oldSourceNode = this.connection.getSource();
				this.oldTargetNode = this.connection.getTarget();
				this.newSourceNode = this.sourceNode;
				this.newTargetNode = this.targetNode;
				this.redo()
			},
			redo : function() {
				this.connection.setSource(this.newSourceNode);
				this.connection.setTarget(this.newTargetNode);
				this.connection.reconnect()
			},
			undo : function() {
				this.connection.setSource(this.oldSourceNode);
				this.connection.setTarget(this.oldTargetNode);
				this.connection.reconnect()
			}
		});
		Interface.gef.command.ResizeNodeCommand = Interface.extend(Interface.commands.Command, {
			constructor : function($, _) {
				this.node = $;
				this.rect = _
			},
			execute : function() {
				this.oldX = this.node.x;
				this.oldY = this.node.y;
				this.oldW = this.node.w;
				this.oldH = this.node.h;
				this.newX = this.rect.x;
				this.newY = this.rect.y;
				this.newW = this.rect.w;
				this.newH = this.rect.h;
				this.redo()
			},
			redo : function() {
				this.node.resize(this.newX, this.newY, this.newW, this.newH)
			},
			undo : function() {
				this.node.resize(this.oldX, this.oldY, this.oldW, this.oldH)
			}
		});
		Interface.gef.command.ResizeConnectionCommand = Interface.extend(Interface.commands.Command, {
			constructor : function($, A, _) {
				this.connection = $;
				this.oldInnerPoints = A;
				this.newInnerPoints = _
			},
			execute : function() {
				this.redo()
			},
			redo : function() {
				this.connection.resizeConnection(this.newInnerPoints)
			},
			undo : function() {
				this.connection.resizeConnection(this.oldInnerPoints)
			}
		});
		Interface.gef.command.RemoveNodeCommand = Interface.extend(Interface.commands.Command, {
			constructor : function($) {
				this.node = $;
				this.parentNode = $.getParent()
			},
			execute : function() {
				this.redo()
			},
			redo : function() {
				this.node.removeForParent()
			},
			undo : function() {
				var _ = this.node, $ = this.parentNode;
				$.addChild(_)
			}
		});
		Interface.gef.command.RemoveConnectionCommand = Interface.extend(Interface.commands.Command, {
			constructor : function($) {
				this.connection = $;
				this.sourceNode = $.getSource();
				this.targetNode = $.getTarget()
			},
			execute : function() {
				this.redo()
			},
			redo : function() {
				this.connection.disconnect()
			},
			undo : function() {
				this.connection.reconnect()
			}
		});
		Interface.gef.command.MoveTextCommand = Interface.extend(Interface.commands.Command, {
			constructor : function(_, C, B, A, $) {
				this.connection = _;
				this.oldTextX = C;
				this.oldTextY = B;
				this.newTextX = A;
				this.newTextY = $
			},
			execute : function() {
				this.redo()
			},
			redo : function() {
				this.connection.updateTextPosition(this.newTextX, this.newTextY)
			},
			undo : function() {
				this.connection.updateTextPosition(this.oldTextX, this.oldTextY)
			}
		});
		Interface.gef.command.EditTextCommand = Interface.extend(Interface.commands.Command, {
			constructor : function(_, $) {
				this.model = _;
				this.oldText = _.name;
				this.newText = $
			},
			execute : function() {
				var type = this.model.type;
				var newName = this.newText;
				var oldName = this.model.text;
				if("transition"==type){//改变边的名称
					if(newName != oldName)
					{
						Interface.Event.trigger(Interface.EventMode.ChangeTransitionName,this.model.source.key, newName, oldName, this.model.source.text);
					}
				}else{//改变节点的名称
					var outTransitions = this.model.sourceConnections;
					var outTransitionNames = [];
					if(null != outTransitions && outTransitions>0){
						for(var i=0;i<outTransitions.length;i++){
							outTransitionNames.push(outTransitions[i].text);
						}
					}
					var reg_normal = new RegExp("^(?!_)(?!.*?_$)[ a-zA-Z0-9_\u4e00-\u9fa5]+$");
					if(!reg_normal.test(newName)){
						Interface.Event.trigger(Interface.EventMode.Alert,"节点名称只允许输入汉字、数字、字母、下划线，不能以下划线开头和结尾！")
						return ;
					}
					if(newName != oldName)
					{
						Interface.Event.trigger(Interface.EventMode.ChangeNodeName, this.model.key, newName, oldName, outTransitionNames);
					}
				}
				this.redo()
			},
			redo : function() {
				this.model.updateText(this.newText)
			},
			undo : function() {
				this.model.updateText(this.oldText)
			}
		});
		Interface.gef.command.MoveAllCommand = Interface.extend(Interface.commands.Command, {
			constructor : function(A, $, _) {
				this.nodes = A;
				this.dx = $;
				this.dy = _;
				var B = [];
				Interface.each(A, function($) {
					Interface.each($.getSourceConnections(), function($) {
						Interface.each(A, function(_) {
							if ($.getTarget() == _)
								B.push($)
						})
					})
				});
				this.connections = B
			},
			execute : function() {
				this.redo()
			},
			redo : function() {
				var A = this.nodes, $ = this.dx, _ = this.dy;
				Interface.each(A, function(A) {
					A.moveTo(A.x + $, A.y + _)
				});
				Interface.each(this.connections, function(A) {
					var B = A.innerPoints;
					Interface.each(B, function(A) {
						A[0] += $;
						A[1] += _
					});
					A.resizeConnection(B)
				})
			},
			undo : function() {
				var A = this.nodes, $ = this.dx, _ = this.dy;
				Interface.each(A, function(A) {
					A.moveTo(A.x - $, A.y - _)
				});
				Interface.each(this.connections, function(A) {
					var B = A.innerPoints;
					Interface.each(B, function(A) {
						A[0] -= $;
						A[1] -= _
					});
					A.resizeConnection(B)
				})
			}
		});
	},
	//初始化XML类
	initXML : function(Interface) {
		Interface.ns("Interface.gef.xml");
		Interface.gef.xml.XmlSerializer = function($) {
			this.model = $;
			this.map = {
				"node" : Interface.xml.AbstractWrapper
			}
		};
		Interface.gef.xml.XmlSerializer.prototype = {
			serialize : function() {
				var $ = [];
				this.appendToBuffer($);
				return Interface.join($)
			},
			appendToBuffer : function($) {
				$.push("<?xml version='1.0' encoding='UTF-8'?>\n");
				$.push("<node>\n");
				this.appendBody($);
				$.push("</node>")
			},
			appendBody : function($) {
				Interface.each(this.model.getChildren(), function(A) {
					var _ = this.getWrapper(A);
					_.appendBuffer($)
				}, this)
			},
			getWrapper : function(node) {
				var type = node.type, A = this.map[type];
				if (!A)
					return {
						appendBuffer : Interface.emptyFn
					};
				else
					return new A(node)
			}
		};
		Interface.gef.xml.AbstractWrapper = function($) {
			this.node = $
		};
		Interface.gef.xml.AbstractWrapper.prototype = {
			appendBuffer : function(_) {
				this.appendHeader(_);
				this.appendAttributes(_);
				var $ = [];
				this.appendBody($);
				this.appendFooter(_, $)
			},
			appendHeader : function($) {
				var nodeType = this.node.getType();
				if('endCancel'==nodeType)
					nodeType = 'end-cancel';
				$.push("  <", nodeType);
			},
			appendAttributes : function(_) {
				var $ = this.node;
				_.push(" text='", $.text, "' g='", $.x, ",", $.y, ",", $.w, ",", $.h, "'")
			},
			appendBody : function($) {
				Interface.each(this.node.getSourceConnections(), function(_) {
					$.push("    <transition");
					if (_.text != null && _.text != "")
						$.push(" name='", _.text);
					$.push("' to='", _.getTarget().text, "'/>\n")
				})
			},
			appendFooter : function(_, $) {
				var nodeType = this.node.getType();
				if('endCancel'==nodeType)
					nodeType = 'end-cancel';
				if ($.length == 0)
					_.push("/>\n");
				else
					_.push(">\n", Interface.join($), "  </", nodeType, ">\n")
			}
		};
		Interface.gef.xml.XmlDeserializer = Interface.extend(Object, {
			constructor : function(_) {
				var $ = null;
				if (typeof(DOMParser) == "undefined") {
					$ = new ActiveXObject("Microsoft.XMLDOM");
					$.async = "false";
					$.loadXML(_)
				} else {
					var A = new DOMParser();
					$ = A.parseFromString(_, "application/xml");
					A = null
				}
				this.xdoc = $
			}
		});

		Interface.ns("Interface.simple.xml");
		Interface.simple.xml.SimpleSerializer = Interface.extend(Interface.gef.xml.XmlSerializer, {
			constructor : function($) {
				this.model = $;
				this.map = {
					"start" : Interface.simple.xml.StartWrapper,
					"end" : Interface.simple.xml.EndWrapper,
					"endCancel" : Interface.simple.xml.EndCancelWrapper,
					"task" : Interface.simple.xml.TaskWrapper,
					"state" : Interface.simple.xml.StateWrapper,
					"join" : Interface.simple.xml.JoinWrapper,
					"fork" : Interface.simple.xml.ForkWrapper,
					"decision" : Interface.simple.xml.DecisionWrapper,
					"sign": Interface.simple.xml.CountersignWrapper,
					"sub": Interface.simple.xml.SubprocessWrapper
				}
			},
			appendToBuffer : function($) {
				$.push("<?xml version='1.0' encoding='UTF-8'?>\n");
				$.push("<process");
				if (this.model.text)
					$.push(" name='" + Interface.flowid + "'");
				if (typeof this.model.key == "string" && this.model.key != null
					&& this.model.key != "" && this.model.key.trim().length != 0)
					$.push(" key='" + this.model.key + "'");
				if (typeof this.model.version == "string" && this.model.version != null
					&& this.model.version != "" && this.model.version.trim().length != 0)
					$.push(" version='" + this.model.version + "'");
				$.push(" xmlns='http://jbpm.org/4.4/jpdl'>\n");
				if (typeof this.model.description == "string" && this.model.description != null
					&& this.model.description != "" && this.model.description.trim().length != 0)
					$.push("  <description>" + this.model.description + "</description>\n");
				// if (this.model.events)
				// 	Interface.each(this.model.events, function(_) {
				// 		$.push("    <on event=\"", _.name, "\">\n");
				// 		$.push("      <event-listener class=\"", _.classname, "\"/>\n");
				// 		$.push("    </on>\n")
				// 	}, this);
				// if (this.model.timers)
				// 	Interface.each(this.model.timers, function(_) {
				// 		$.push("    <timer duedate=\"", _.duedate, "\" repeat=\"", _.repeat, "\" duedatetime=\"", _.duedatetime, "\">\n");
				// 		$.push("      <description>", _.description, "</description>\n");
				// 		$.push("      <event-listener class=\"", _.classname, "\"/>\n");
				// 		$.push("    </timer>\n")
				// 	}, this);
				// if (this.model.swimlanes)
				// 	Interface.each(this.model.swimlanes, function(_) {
				// 		$.push("    <swimlane name=\"", _.name, "\" assignee=\"", _.assignee, "\" candidate-users=\"", _.candidateUsers, "\" candidate-groups=\"", _.candidateGroups, "\">\n");
				// 		$.push("      <description>", _.description, "</description>\n");
				// 		$.push("    </swimlane>\n")
				// 	}, this);
				this.appendBody($);
				$.push("</process>")
			}
		});
		Interface.simple.xml.AbstractNodeWrapper = Interface.extend(Interface.gef.xml.AbstractWrapper, {
			appendAttributes : function(_) {
				var $ = this.node;
				_.push(" name='", $.text, "' key='",$.key,"' g='");
				if ($.type == "start" || $.type == "state" || $.type == "end" || $.type == "cancel"
					|| $.type == "error" || $.type == "decision" || $.type == "fork" || $.type == "join")
					_.push($.x, ",", $.y, ",", $.w, ",", $.h, "'");
				else
					_.push(($.x), ",", ($.y), ",", ($.w), ",", ($.h), "'");
			},
			appendBody : function($) {
				// var nodeName = this.node.text;
				// var nodeTimerSetting = Interface.Editor.findNodeTimerSettingByNodeName(nodeName);
				// if(null != nodeTimerSetting && nodeTimerSetting.actionTimerEnable == true){
				// 	var duedate = nodeTimerSetting.dayDuedate*24*60+nodeTimerSetting.hourDuedate*60+nodeTimerSetting.minuteDuedate;
				// 	var repeat = nodeTimerSetting.dayRepeat*24*60+nodeTimerSetting.hourRepeat*60+nodeTimerSetting.minuteRepeat;
				// 	$.push("    <on event=\"timeout\">\n");
				// 	$.push("        <timer duedate=\""+duedate+" minutes\"");
				// 	if(repeat>0){
				// 		$.push(" repeat='"+repeat+" minutes'");
				// 	}
				// 	$.push(" />\n");
				// 	$.push("        <event-listener class=\""+Interface.NODE_TIMER_LISTENER+"\" />\n");
				// 	$.push("    </on>\n")
				// }
				Interface.each(this.node.getSourceConnections(), function(A) {
					$.push("    <transition");
					if (A.text != null && A.text != "")
						$.push(" name='", A.text, "'");
					if (A.innerPoints.length != 0 || A.textX != 0 || A.textY != 0) {
						$.push(" g='");
						Interface.each(A.innerPoints, function(B, _) {
							$.push(parseInt(B[0], 10), ",", parseInt(B[1], 10));
							if (_ != A.innerPoints.length - 1)
								$.push(";")
						});
						var _ = this.getTextPosition(A);
						$.push(_);
						$.push("'")
					}
					if('end'== A.getTarget().type){
						$.push(" to='结束'>\n");
					}else if('endCancel'== A.getTarget().type){
						$.push(" to='中止'>\n");
					}else{
						$.push(" to='", A.getTarget().text, "'>\n");
					}
					// if(null != nodeTimerSetting && nodeTimerSetting.clockTimerEnable == true && nodeTimerSetting.transitionName==A.text){
					// 	var clockDuedate = nodeTimerSetting.dayClock*24*60+nodeTimerSetting.hourClock*60+nodeTimerSetting.minuteClock;
					// 	$.push("     <timer duedate=\""+ clockDuedate +" minutes\"/>\n")
					// }
					// $.push("     <event-listener class=\""+ Interface.EVENT_LISTENER +"\"/>\n");
					$.push("    </transition>\n");
				}, this)
			},
			getTextPosition : function(E) {
				var P = E.getSource(), K = new Interface.Geom.Rect(parseInt(P.x, 10), parseInt(
					P.y, 10), parseInt(P.w, 10), parseInt(P.h, 10)), N = E
						.getTarget(), J = new Interface.Geom.Rect(parseInt(N.x, 10), parseInt(
					N.y, 10), parseInt(N.w, 10), parseInt(N.h, 10)),
					$ = new Interface.Geom.Line(parseInt(K.x, 10) + parseInt(K.w, 10) / 2,
												parseInt(K.y, 10) + parseInt(K.h, 10) / 2,
												parseInt(J.x, 10) + parseInt(J.w, 10) / 2,
												parseInt(J.y, 10)
																																   + parseInt(J.h, 10) / 2);
				//这里做过非空判断，这里的算法在计算我们自己的JPDL时，会出现F,C,L，B为null的情况。 JACKY 2010-09-06
				var F = (K.getCrossPoint($) == null ? new Object({x:0, y:0}):K.getCrossPoint($));
				var C = (J.getCrossPoint($) == null ? new Object({x:10, y:10}): J.getCrossPoint($));
				var L = (F == null ? 0 : (F.x + C.x) / 2);
				var B = (F == null ? 0 :(F.y + C.y) / 2);

				if (E.innerPoints.length > 0) {
					var A = E.innerPoints[0], _ = E.innerPoints[E.innerPoints.length
																- 1], O = [];
					O.push([F.x, F.y]);
					Interface.each(E.innerPoints, function($) {
						O.push([$[0], $[1]])
					});
					O.push([C.x, C.y]);
					var H = O.length, G = 0, D = 0;
					if ((H % 2) == 0) {
						var I = O[H / 2 - 1], M = O[H / 2];
						G = (I[0] + M[0]) / 2;
						D = (I[1] + M[1]) / 2
					} else {
						G = O[(H - 1) / 2][0];
						D = O[(H - 1) / 2][1]
					}
					var R = parseInt(E.textX + L - G, 10), Q = parseInt(
						E.textY + B - D, 10);
					return ":" + R + "," + Q
				} else if (E.textX != 0 && E.textY != 0)
					return parseInt(E.textX, 10) + "," + parseInt(E.textY, 10);
				else
					return ""
			}
		});
		Interface.simple.xml.SimpleDeserializer = Interface.extend(Interface.gef.xml.XmlDeserializer, {
			decode : function() {
				var pmodel = new Interface.simple.model.ProcessModel();
				this.modelMap = {};
				this.domMap = {};
				this.parseRoot(pmodel);
				delete this.modelMap;
				delete this.domMap;
				return pmodel;
			},
			parseRoot : function(processModel) {
				var $ = this.xdoc.documentElement;
				processModel.text = $.getAttribute("name");
				processModel.key = $.getAttribute("key");
				processModel.version = $.getAttribute("version");
				processModel.description = this.getElementContent($, "description");
				this.bindEvents($, processModel);
				this.bindTimers($, processModel);
				this.bindSwimlanes($, processModel);
				Interface.each($.childNodes, function(childNode) {
					this.parseNode(childNode, processModel)
				}, this);
				Interface.each(processModel.getChildren(), function(childNode) {
					this.parseConnections(childNode)
				}, this)
			},
			parseNode : function(node, processModel) {
				var $ = node.nodeName;
				switch (node.nodeName) {
					case "start" :
						this.parseStart(node, processModel);
						break;
					case "end" :
						this.parseEnd(node, processModel);
						break;
					case "end-cancel" :
						this.parseEndCancel(node, processModel);
						break;
					case "task" :
						this.parseTask(node, processModel);
						break;
					case "state" ://新的节点
						this.parseState(node, processModel);
						break;
					case "fork" ://新的节点
						this.parseFork(node, processModel);
						break;
					case "join" ://新的节点
						this.parseJoin(node, processModel);
						break;
					case "decision" ://新的节点
						this.parseDecision(node, processModel);
						break;
					case "sign" ://新增会签节点
						this.parseCountersign(node, processModel);
						break;
					case "sub" ://新增子流程节点
						this.parseSubprocess(node, processModel);
						break;
				}
			},
			parseConnections : function(node) {
				var _ = this.domMap[node.text];
				Interface.each(_.childNodes, function(_) {
					if (_.nodeName == "transition")
						this.parseConnection(_, node)
				}, this)
			},
			parseConnection : function(A, _) {
				var B = new Interface.simple.model.TransitionModel();
				B.text = A.getAttribute("name");
				var $ = A.getAttribute("to"), C = this.modelMap[$];
				if(C)
				{
					B.setSource(_);
					_.addSourceConnection(B);
					B.setTarget(C);
					C.addTargetConnection(B);
					this.bindConnectionLocation(A, B)
				}
			},
			bindConnectionLocation : function(C, $) {
				var _ = C.getAttribute("g");
				if (!_)
					return;
				var E = _, B = _.split(":");
				if (_.indexOf(":") != -1) {
					E = B[1];
					if (B[0].length > 0) {
						var F = B[0].split(";"), D = [];
						Interface.each(F, function($) {
							var _ = $.split(",");
							D.push([parseInt(_[0], 10), parseInt(_[1], 10)])
						});
						$.innerPoints = D
					}
				} else
					E = _;
				var A = E.split(",");
				$.textX = parseInt(A[0], 10);
				$.textY = parseInt(A[1], 10);
				this.calculdateTextPosition($)
			},
			calculdateTextPosition : function(E) {
				var P = E.getSource(),
					K = new Interface.Geom.Rect(parseInt(P.x, 10), parseInt(P.y, 10),
												parseInt(P.w, 10), parseInt(P.h, 10)),
					N = E.getTarget(),
					J = new Interface.Geom.Rect(parseInt(N.x, 10), parseInt(N.y, 10),
												parseInt(N.w, 10), parseInt(N.h, 10)),
					$ = new Interface.Geom.Line(parseInt(K.x, 10) + parseInt(K.w, 10) / 2,
												parseInt(K.y, 10) + parseInt(K.h, 10) / 2,
												parseInt(J.x, 10) + parseInt(J.w, 10) / 2,
												parseInt(J.y, 10) + parseInt(J.h, 10) / 2);
				//这里做过非空判断，这里的算法在计算我们自己的JPDL时，会出现F,C,L，B为null的情况。 JACKY 2010-09-06
				var F = (K.getCrossPoint($) == null ? new Object({x:0, y:0}):K.getCrossPoint($));
				var C = (J.getCrossPoint($) == null ? new Object({x:10, y:10}): J.getCrossPoint($));
				var L = (F == null ? 0 : (F.x + C.x) / 2);
				var B = (F == null ? 0 :(F.y + C.y) / 2);

				if (E.innerPoints.length > 0) {
					var A = E.innerPoints[0], _ = E.innerPoints[E.innerPoints.length
																- 1], O = [];
					O.push([F.x, F.y]);
					Interface.each(E.innerPoints, function($) {
						O.push([$[0], $[1]])
					});
					O.push([C.x, C.y]);
					var H = O.length, G = 0, D = 0;
					if ((H % 2) == 0) {
						var I = O[H / 2 - 1], M = O[H / 2];
						G = (I[0] + M[0]) / 2;
						D = (I[1] + M[1]) / 2
					} else {
						G = O[(H - 1) / 2][0];
						D = O[(H - 1) / 2][1]
					}
					var R = parseInt(E.textX + L - G, 10), Q = parseInt(
						E.textY + B - D, 10);
					E.textX -= L - G;
					E.textY -= B - D
				}
			},
			bindNodeLocation : function(B, _) {
				var $ = B.getAttribute("g"), A = $.split(",");
				_.x = parseInt(A[0], 10);
				_.y = parseInt(A[1], 10);
				_.w = parseInt(A[2], 10);
				_.h = parseInt(A[3], 10)
			},
			bindEvents : function(_, $) {
				$.events = [];
				Interface.each(_.childNodes, function(_) {
					if (_.nodeName == "on")
						$.events.push({
										  name : _.getAttribute("event"),
										  classname : this.getElementAttribute(_, "event-listener", "class")
									  })
				}, this)
			},
			bindTimers : function(_, $) {
				$.timers = [];
				Interface.each(_.childNodes, function(_) {
					if (_.nodeName == "timer")
						$.timers.push({
										  duedate : _.getAttribute("duedate"),
										  repeat : _.getAttribute("repeat"),
										  duedatetime : _.getAttribute("duedatetime"),
										  description : this.getElementContent(_, "description"),
										  classname : this.getElementContent(_, "event-listener",
																			 "classname")
									  })
				}, this)
			},
			bindSwimlanes : function(_, $) {
				$.swimlanes = [];
				Interface.each(_.childNodes, function(_) {
					if (_.nodeName == "swimlane")
						$.swimlanes.push({
											 name : _.getAttribute("name"),
											 assignee : _.getAttribute("assignee"),
											 candidateUsers : _.getAttribute("candidate-users"),
											 candidateGroups : _.getAttribute("candidate-groups"),
											 description : this.getElementContent(_, "description")
										 })
				}, this)
			},
			getElementContent : function(_, A) {
				var $ = null;
				Interface.each(_.childNodes, function(_) {
					if (_.nodeName == A) {
						$ = _.textContent;
						return false
					}
				});
				return $
			},
			getElementAttribute : function(_, A, B) {
				var $ = null;
				Interface.each(_.childNodes, function(_) {
					if (_.nodeName == A) {
						$ = _.getAttribute(B);
						return false
					}
				});
				return $
			},
			parseStart : function(B, A) {
				var _ = new Interface.simple.model.StartModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.form = B.getAttribute("form");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_)
			},
			parseEnd : function(B, A) {
				var _ = new Interface.simple.model.EndModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.ends = B.getAttribute("ends");
				_.state = B.getAttribute("state");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_)
			},
			parseTask : function(B, A) {
				var taskModel = new Interface.simple.model.TaskModel(), $ = B.getAttribute("name");
				taskModel.key = B.getAttribute("key");
				taskModel.text = $;
				taskModel.assignee = B.getAttribute("assignee");
				taskModel.candidateUsers = B.getAttribute("candidate-users");
				taskModel.candidateGroups = B.getAttribute("candidate-groups");
				taskModel.swimlane = B.getAttribute("swimlane");
				taskModel.form = B.getAttribute("form");
				taskModel.duedate = B.getAttribute("duedate");
				taskModel.onTransition = B.getAttribute("on-transition");
				taskModel.completion = B.getAttribute("completion");
				taskModel.notification = this.getElementAttribute(B, "notification", "template");
				taskModel.reminder = this.getElementAttribute(B, "reminder", "template");
				taskModel.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, taskModel);
				this.bindEvents(B, taskModel);
				this.bindTimers(B, taskModel);
				this.modelMap[$] = taskModel;
				this.domMap[$] = B;
				A.addChild(taskModel)
			},
			parseState : function(B, A) {
				var _ = new Interface.simple.model.StateModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.assignee = B.getAttribute("assignee");
				_.candidateUsers = B.getAttribute("candidate-users");
				_.candidateGroups = B.getAttribute("candidate-groups");
				_.swimlane = B.getAttribute("swimlane");
				_.form = B.getAttribute("form");
				_.duedate = B.getAttribute("duedate");
				_.onTransition = B.getAttribute("on-transition");
				_.completion = B.getAttribute("completion");
				_.notification = this
					.getElementAttribute(B, "notification", "template");
				_.reminder = this.getElementAttribute(B, "reminder", "template");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.bindTimers(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_)
			},
			parseJoin : function(B, A) {
				var _ = new Interface.simple.model.JoinModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.assignee = B.getAttribute("assignee");
				_.candidateUsers = B.getAttribute("candidate-users");
				_.candidateGroups = B.getAttribute("candidate-groups");
				_.swimlane = B.getAttribute("swimlane");
				_.form = B.getAttribute("form");
				_.duedate = B.getAttribute("duedate");
				_.onTransition = B.getAttribute("on-transition");
				_.completion = B.getAttribute("completion");
				_.notification = this
					.getElementAttribute(B, "notification", "template");
				_.reminder = this.getElementAttribute(B, "reminder", "template");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.bindTimers(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_)
			},
			parseFork : function(B, A) {
				var _ = new Interface.simple.model.ForkModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.assignee = B.getAttribute("assignee");
				_.candidateUsers = B.getAttribute("candidate-users");
				_.dateGroups = B.getAttribute("candidate-groups");
				_.swimlane = B.getAttribute("swimlane");
				_.form = B.getAttribute("form");
				_.duedate = B.getAttribute("duedate");
				_.onTransition = B.getAttribute("on-transition");
				_.completion = B.getAttribute("completion");
				_.notification = this
					.getElementAttribute(B, "notification", "template");
				_.reminder = this.getElementAttribute(B, "reminder", "template");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.bindTimers(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_);
			},
			parseEndCancel : function(B, A) {
				var _ = new Interface.simple.model.EndCancelModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.ends = B.getAttribute("ends");
				_.state = B.getAttribute("state");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_)
			},
			parseDecision : function(B, A) {
				var _ = new Interface.simple.model.DecisionModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.rotate = (B.getAttribute("rotate") == "undefined" || B.getAttribute("rotate") == null || B.getAttribute("rotate") == undefined ? 0 : B.getAttribute("rotate")) ;
				_.assignee = B.getAttribute("assignee");
				_.candidateUsers = B.getAttribute("candidate-users");
				_.candidateGroups = B.getAttribute("candidate-groups");
				_.swimlane = B.getAttribute("swimlane");
				_.form = B.getAttribute("form");
				_.duedate = B.getAttribute("duedate");
				_.onTransition = B.getAttribute("on-transition");
				_.completion = B.getAttribute("completion");
				_.notification = this.getElementAttribute(B, "notification", "template");
				_.reminder = this.getElementAttribute(B, "reminder", "template");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.bindTimers(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_)
			},
			parseCountersign : function(B, A) {
				var _ = new Interface.simple.model.CountersignModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.assignee = B.getAttribute("assignee");
				_.candidateUsers = B.getAttribute("candidate-users");
				_.candidateGroups = B.getAttribute("candidate-groups");
				_.swimlane = B.getAttribute("swimlane");
				_.form = B.getAttribute("form");
				_.duedate = B.getAttribute("duedate");
				_.onTransition = B.getAttribute("on-transition");
				_.completion = B.getAttribute("completion");
				_.notification = this
					.getElementAttribute(B, "notification", "template");
				_.reminder = this.getElementAttribute(B, "reminder", "template");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.bindTimers(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_)
			},
			parseSubprocess : function(B, A) {
				var _ = new Interface.simple.model.SubprocessModel(), $ = B.getAttribute("name");
				_.key = B.getAttribute("key");
				_.text = $;
				_.assignee = B.getAttribute("assignee");
				_.candidateUsers = B.getAttribute("candidate-users");
				_.candidateGroups = B.getAttribute("candidate-groups");
				_.swimlane = B.getAttribute("swimlane");
				_.form = B.getAttribute("form");
				_.duedate = B.getAttribute("duedate");
				_.onTransition = B.getAttribute("on-transition");
				_.completion = B.getAttribute("completion");
				_.notification = this.getElementAttribute(B, "notification", "template");
				_.reminder = this.getElementAttribute(B, "reminder", "template");
				_.description = this.getElementContent(B, "description");
				this.bindNodeLocation(B, _);
				this.bindEvents(B, _);
				this.bindTimers(B, _);
				this.modelMap[$] = _;
				this.domMap[$] = B;
				A.addChild(_)
			}

		});
		Interface.simple.xml.StartWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.StartWrapper.superclass.appendAttributes.call(this, _);
				var $ = this.node;
				if (typeof $.form == "string" && $.form.trim().length != 0)
					_.push(" form=\"" + $.form + "\"")
			}
		});
		Interface.simple.xml.EndWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.EndWrapper.superclass.appendAttributes.call(this, _);
				var $ = this.node;
				if (typeof $.ends == "string" && $.ends.trim().length != 0)
					_.push(" ends=\"" + $.ends + "\"");
				if (typeof $.state == "string" && $.state.trim().length != 0)
					_.push(" state=\"" + $.state + "\"")
			}
		});
		Interface.simple.xml.EndCancelWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.EndCancelWrapper.superclass.appendAttributes.call(this, _);
				var $ = this.node;
				if (typeof $.ends == "string" && $.ends.trim().length != 0)
					_.push(" ends=\"" + $.ends + "\"");
				if (typeof $.state == "string" && $.state.trim().length != 0)
					_.push(" state=\"" + $.state + "\"")
			}
		});
		Interface.simple.xml.TaskWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendAttributes.call(this, _);
			},
			appendBody : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendBody.call(this, _);
			}
		});
		Interface.simple.xml.StateWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.StateWrapper.superclass.appendAttributes.call(this, _);
				var $ = this.node;
				if (typeof $.assignee == "string" && $.assignee.trim().length != 0)
					_.push(" assignee=\"" + $.assignee + "\"");
				if (typeof $.candidateUsers == "string"
					&& $.candidateUsers.trim().length != 0)
					_.push(" candidate-users=\"" + $.candidateUsers + "\"");
				if (typeof $.candidateGroups == "string"
					&& $.candidateGroups.trim().length != 0)
					_.push(" candidate-groups=\"" + $.candidateGroups + "\"");
				if (typeof $.swimlane == "string" && $.swimlane.trim().length != 0)
					_.push(" swimlane=\"" + $.swimlane + "\"");
				if (typeof $.duedate == "string" && $.duedate.trim().length != 0)
					_.push(" duedate=\"" + $.duedate + "\"");
				if (typeof $.onTransition == "string"
					&& $.onTransition.trim().length != 0)
					_.push(" on-transition=\"" + $.onTransition + "\"");
				if (typeof $.completion == "string" && $.completion.trim().length != 0)
					_.push(" completion=\"" + $.completion + "\"")
			},
			appendBody : function(_) {
				Interface.simple.xml.StateWrapper.superclass.appendBody.call(this, _);
				var $ = this.node;
				if (typeof $.notification == "string"
					&& $.notification.trim().length != 0)
					_.push("    <notification template=\"" + $.notification + "\"/>\n");
				if (typeof $.reminder == "string" && $.reminder.trim().length != 0)
					_.push("    <reminder template=\"" + $.reminder + "\"/>\n")
			}
		});
//新增会签节点
		Interface.simple.xml.CountersignWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendAttributes.call(this, _);
				var $ = this.node;
				var nodeName = $.text;
				var groupName = Interface.flowid+"_"+nodeName;
				_.push(" candidate-groups=\"" + groupName + "\"");
			},
			appendBody : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendBody.call(this, _);
			}
		});
//新增子流程节点
		Interface.simple.xml.SubprocessWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendAttributes.call(this, _);
			},
			appendBody : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendBody.call(this, _);
			}
		});
		Interface.simple.xml.JoinWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendAttributes.call(this, _);
				// var $ = this.node;
				// var nodeName = $.text;
				// Interface.Event.trigger(Interface.EventMode.GetProcessParameterByNames,nodeName,'multiplicity',function(processParameter){
				// 	if(processParameter != null){
				// 		_.push(" multiplicity=\"" + processParameter.parameterValue + "\"");
				// 	}
				// });
			},
			appendBody : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendBody.call(this, _);
			}
		});
		Interface.simple.xml.ForkWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendAttributes.call(this, _);
			},
			appendBody : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendBody.call(this, _);
			}
		});
		Interface.simple.xml.DecisionWrapper = Interface.extend(Interface.simple.xml.AbstractNodeWrapper, {
			appendAttributes : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendAttributes.call(this, _);
				_.push(" rotate='",this.node.rotate,"'")
			},
			appendBody : function(_) {
				Interface.simple.xml.TaskWrapper.superclass.appendBody.call(this, _);
			}
		});
	},
	//初始化编辑器支持类
	initEditorSupport : function(Interface) {
		Interface.ns("Interface.gef.support");
		Interface.gef.support.AbstractGraphicalEditor = Interface.extend(Interface.gef.Editor, {
			constructor : function() {
				this.editDomain = this.createEditDomain();
				this.graphicalViewer = this.createGraphicalViewer()
			},
			createGraphicalViewer : function() {
				return new Interface.gef.GraphicalViewer()
			},
			getGraphicalViewer : function() {
				return this.graphicalViewer
			},
			setGraphicalViewer : function($) {
				this.graphicalViewer = $
			},
			createEditDomain : function() {
				var $ = new Interface.gef.EditDomain();
				$.setEditor(this);
				return $
			},
			setEditDomain : function($) {
				this.editDomain = $
			},
			getEditDomain : function() {
				return this.editDomain
			},
			getModelFactory : function() {
				return this.modelFactory
			},
			setModelFactory : function($) {
				this.modelFactory = $
			},
			getEditPartFactory : function() {
				return this.editPartFactory
			},
			setEditPartFactory : function($) {
				this.editPartFactory = $
			},
			enable : function() {
				this.getGraphicalViewer().getBrowserListener().enable()
			},
			disable : function() {
				this.getGraphicalViewer().getBrowserListener().disable()
			},
			setWidth : function($){
				if (Interface.isVml)
					;
				else {
					var DomCID = "__gef_simple_center__";
					if(Interface.parentid != "" && Interface.parentid != null){
						DomCID = "_" + Interface.parentid + "_center_";
					}
					var svgId = document.getElementById(DomCID).childNodes[0].id;
					var _ = document.getElementById(svgId);
					_.setAttribute("width", $)
				}
			},
			setHeight : function($) {
				if (Interface.isVml)
					;
				else {
					var DomCID = "__gef_simple_center__";
					if(Interface.parentid != "" && Interface.parentid != null){
						DomCID = "_" + Interface.parentid + "_center_";
					}

					var svgId = document.getElementById(DomCID).childNodes[0].id;
					var A = document.getElementById(svgId);
					A.setAttribute("height", $)
				}
			},
			addWidth : function($) {
				if (Interface.isVml)
					;
				else {
					var DomCID = "__gef_simple_center__";
					if(Interface.parentid != "" && Interface.parentid != null){
						DomCID = "_" + Interface.parentid + "_center_";
					}
					var svgId = document.getElementById(DomCID).childNodes[0].id;
					var _ = document.getElementById(svgId), A = parseInt(_.getAttribute("width"), 10);
					_.setAttribute("width", A + $)
				}
			},
			addHeight : function($) {
				if (Interface.isVml)
					;
				else {
					var DomCID = "__gef_simple_center__";
					if(Interface.parentid != "" && Interface.parentid != null){
						DomCID = "_" + Interface.parentid + "_center_";
					}

					var svgId = document.getElementById(DomCID).childNodes[0].id;
					var A = document.getElementById(svgId);
					var _ = parseInt(A.getAttribute("height"), 10);
					A.setAttribute("height", _ + $)
				}
			}
		});
		Interface.gef.support.DefaultGraphicalEditorWithPalette = Interface.extend(Interface.gef.support.AbstractGraphicalEditor, {
			init : function($) {
				var _ = $.getObject();
				this.getGraphicalViewer().setContents(_);
				this.editDomain = new Interface.gef.EditDomain();
				this.editDomain.setEditor(this)
			},
			setWorkbenchPage : function($) {
				this.workbenchPage = $
			},
			getPaletteHelper : function() {
				if (!this.paletteHelper)
					this.paletteHelper = this.createPaletteHelper();
				return this.paletteHelper
			},
			createPaletteHelper : Interface.emptyFn,
			createGraphicalViewer : function() {
				return new Interface.gef.support.DefaultGraphicalViewer(this)
			},
			render : function() {
				this.getGraphicalViewer().render()
			}
		});
		Interface.gef.support.AbstractEditPartViewer = Interface.extend(Interface.gef.EditPartViewer, {
			getContents : function() {
				return this.rootEditPart.getContents()
			},
			setContents : function($) {
				this.rootEditPart.setContents($)
			},
			getRootEditPart : function() {
				return this.rootEditPart
			},
			setRootEditPart : function($) {
				this.rootEditPart = $
			},
			getEditDomain : Interface.emptyFn,
			setEditDomain : Interface.emptyFn
		});
		Interface.gef.support.AbstractGraphicalViewer = Interface.extend(Interface.gef.support.AbstractEditPartViewer, {});
		//绘图部分
		Interface.gef.support.DefaultGraphicalViewer = Interface.extend(Interface.gef.support.AbstractGraphicalViewer, {
			constructor : function($) {
				this.editor = $;
				this.rootEditPart = this.createRootEditPart();
				Interface.gef.support.DefaultGraphicalViewer.superclass.constructor.call(this);
				this.browserListener = new Interface.gef.tracker.BrowserListener(this)
			},
			getActivePalette : function() {
				return this.editor.getPaletteHelper().getActivePalette()
			},
			createRootEditPart : function() {
				return new Interface.gef.support.DefaultRootEditPart(this)
			},
			getEditDomain : function() {
				return this.editor.getEditDomain()
			},
			getEditPartFactory : function() {
				return this.editor.editPartFactory
			},
			setContents : function(_) {
				var $ = null, D = null;
				if (typeof _ == "string") {
					D = _;
					var C = this.editor.getModelFactory();
					$ = C.createModel(_)
				} else {
					$ = _;
					D = $.getType()
				}
				var B = this.editor.getEditPartFactory(), A = B.createEditPart(D);
				A.setModel($);
				this.rootEditPart.setContents(A)
			},
			getLayer : function($) {
				return this.rootEditPart.getFigure().getLayer($)
			},
			getPaletteConfig : function(_, $) {
				return this.editor.getPaletteHelper().getPaletteConfig(_, $)
			},
			render : function() {
				if (this.rendered == true)
					return;
				var A = this.editor.workbenchPage.getWorkbenchWindow().width - 2,
					$ = this.editor.workbenchPage.getWorkbenchWindow().height - 2,
					_ = document.createElement("div");
				_.className = "Interface-workbenchpage";
				_.style.width = A + "px";
				_.style.height = $ + "px";
				if(typeof Interface.parent != "undefined"){
					Interface.parent.appendChild(_);
				}else
				{
					document.body.appendChild(_);
				}
				this.el = _;
				var C = document.createElement("div");
				C.className = "Interface-canvas";
				C.style.position = "absolute";
				C.style.left = "50px";
				C.style.top = "50px";
				C.style.border = "1px solid black";
				C.style.width = (A - 216) + "px";
				C.style.height = $ + "px";
				_.appendChild(C);
				this.canvasEl = C;
				var B = document.createElement("div");
				B.className = "Interface-palette";
				B.style.left = (A - 216) + "px";
				B.style.width = "199px";
				B.style.height = $ + "px";
				_.appendChild(B);
				this.paletteEl = B;
				this.editor.getPaletteHelper().render(B);
				this.rootEditPart.render();
				this.rendered = true
			},
			getPaletteLocation : function() {
				var $ = this.paletteEl;
				if (!this.paletteLocation)
					this.paletteLocation = {
						x : Interface.getInt($.style.left),
						y : Interface.getInt($.style.top),
						w : Interface.getInt($.style.width),
						h : Interface.getInt($.style.height)
					};
				return this.paletteLocation
			},
			getCanvasLocation : function() {
				var $ = this.canvasEl;
				if (!this.canvasLocation)
					this.canvasLocation = {
						x : Interface.getInt($.style.left),
						y : Interface.getInt($.style.top),
						w : Interface.getInt($.style.width),
						h : Interface.getInt($.style.height)
					};
				return this.canvasLocation
			},
			getEditor : function() {
				return this.editor
			},
			getBrowserListener : function() {
				return this.browserListener
			}
		});
		Interface.gef.support.DefaultRootEditPart = Interface.extend(Interface.gef.editparts.AbstractRootEditPart, {
			constructor : function($) {
				Interface.gef.support.DefaultRootEditPart.superclass.constructor.call(this);
				this.setViewer($);
				this.figure = this.createFigure()
			},
			createFigure : function() {
				return new Interface.figure.GraphicalViewport(this)
			},
			getParentEl : function() {
				return this.getViewer().canvasEl
			},
			render : function() {
				this.figure.render();
				this.getContents().refresh()
			}
		});
		Interface.gef.support.PaletteHelper = Interface.extend(Object, {
			getSource : Interface.emptyFn,
			render : Interface.emptyFn,
			getPaletteConfig : Interface.emptyFn
		});
	},
	//初始化编辑器模型
	initEditorModel : function(Interface) {
		Interface.ns("Interface.model");
		Interface.model.Model = Interface.extend(Object, {
			constructor : function($) {
				this.listeners = [];
				$ = $ ? $ : {};
				Interface.apply(this, $)
			},
			addChangeListener : function($) {
				this.listeners.push($)
			},
			removeChangeListener : function($) {
				this.listeners.remove($)
			},
			notify : function($, _) {
				for (var A = 0; A < this.listeners.length; A++)
					this.listeners[A].notifyChanged($, _)
			},
			getId : function() {
				if (this.id == null || this.id == undefined)
					this.id = Interface.id();
				return this.id
			},
			getType : function() {
				if (this.type == null || this.type == undefined)
					this.type = "node";
				return this.type
			},
			getEditPart : function() {
				return this.editPart
			},
			setEditPart : function($) {
				this.editPart = $
			}
		});
		Interface.model.ModelChangeListener = Interface.extend(Object, {
			notifyChanged : Interface.emptyFn
		});
		Interface.model.NodeModel = Interface.extend(Interface.model.Model, {
			CHILD_ADDED : "CHILD_ADDED",
			NODE_MOVED : "NODE_MOVED",
			NODE_RESIZED : "NODE_RESIZED",
			TEXT_UPDATED : "TEXT_UPDATED",
			CONNECTION_SOURCE_ADDED : "CONNECTION_SOURCE_ADDED",
			CONNECTION_TARGET_ADDED : "CONNECTION_TARGET_ADDED",
			CHILD_REMOVED_FROM_PARENT : "CHILD_REMOVED_FROM_PARENT",
			constructor : function($) {
				this.text = "untitled";
				this.x = 0;
				this.y = 0;
				this.w = 0;
				this.h = 0;
				this.rotate = 0;
				this.key = "";
				this.children = [];
				this.sourceConnections = [];
				this.targetConnections = [];
				Interface.model.NodeModel.superclass.constructor.call(this, $)
			},
			getText : function() {
				return this.text
			},
			setParent : function($) {
				this.parent = $
			},
			getParent : function() {
				return this.parent
			},
			setChildren : function($) {
				this.children = $
			},
			getChildren : function() {
				return this.children
			},
			addChild : function($) {
				this.children.push($);
				$.setParent(this);
				this.notify(this.CHILD_ADDED, $)
			},
			removeChild : function($) {
				this.children.remove($);
				$.setParent(null);
				$.notify(this.CHILD_REMOVED_FROM_PARENT, $)
			},
			getSourceConnections : function() {
				return this.sourceConnections
			},
			getTargetConnections : function() {
				return this.targetConnections
			},
			addSourceConnection : function($) {
				if ($.getSource() == this && this.sourceConnections.indexOf($) == -1) {
					this.sourceConnections.push($);
					this.notify(this.CONNECTION_SOURCE_ADDED)
				}
			},
			addTargetConnection : function($) {
				if ($.getTarget() == this && this.targetConnections.indexOf($) == -1) {
					this.targetConnections.push($);
					this.notify(this.CONNECTION_TARGET_ADDED)
				}
			},
			removeSourceConnection : function($) {
				if ($.getSource() == this && this.sourceConnections.indexOf($) != -1)
					this.sourceConnections.remove($)
			},
			removeTargetConnection : function($) {
				if ($.getTarget() == this && this.targetConnections.indexOf($) != -1)
					this.targetConnections.remove($)
			},
			moveTo : function(_, $) {
				this.x = _;
				this.y = $;
				this.notify(this.NODE_MOVED)
			},
			resize : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				this.notify(this.NODE_RESIZED)
			},
			updateText : function($) {
				this.text = $;
				this.notify(this.TEXT_UPDATED)
			},
			removeForParent : function() {
				this.parent.removeChild(this);
				this.notify(this.CHILD_REMOVED_FROM_PARENT)
			}
		});
		Interface.model.ConnectionModel = Interface.extend(Interface.model.Model, {
			RECONNECTED : "RECONNECTED",
			DISCONNECTED : "DISCONNECTED",
			CONNECTION_RESIZED : "CONNECTION_RESIZED",
			CONNECTION_TEXT_UPDATED : "CONNECTION_TEXT_UPDATED",
			TEXT_POSITION_UPDATED : "TEXT_POSITION_UPDATED",
			constructor : function($) {
				this.x1 = 0;
				this.y1 = 0;
				this.x2 = 0;
				this.y2 = 0;
				this.text = "untitled";
				this.textX = 0;
				this.textY = 0;
				this.innerPoints = [];
				Interface.model.ConnectionModel.superclass.constructor.call(this, $)
			},
			getText : function() {
				return this.text
			},
			getSource : function() {
				return this.source
			},
			setSource : function($) {
				this.source = $
			},
			getTarget : function() {
				return this.target
			},
			setTarget : function($) {
				this.target = $
			},
			reconnect : function() {
				this.notify(this.RECONNECTED);
				this.source.addSourceConnection(this);
				this.target.addTargetConnection(this)
			},
			disconnect : function() {
				this.notify(this.DISCONNECTED);
				this.source.removeSourceConnection(this);
				this.target.removeTargetConnection(this)
			},
			resizeConnection : function($) {
				this.innerPoints = $;
				this.notify(this.CONNECTION_RESIZED)
			},
			updateText : function($) {
				this.text = $;
				this.notify(this.CONNECTION_TEXT_UPDATED)
			},
			updateTextPosition : function(_, $) {
				this.textX = _;
				this.textY = $;
				this.notify(this.TEXT_POSITION_UPDATED)
			}
		});
	},
	//初始化编辑器任务
	initTracker : function(Interface) {
		Interface.ns("Interface.gef.tracker");
		Interface.gef.tracker.BrowserListener = Interface.extend(Object, {
			constructor : function($) {
				this.graphicalViewer = $;
				this.selectionManager = new Interface.gef.tracker.SelectionManager(this);
				this.enabled = true;
				this.dragging = false;
				this.initTrackers();
				this.initEvents(Interface.parent)
			},
			initTrackers : function() {
				this.trackers = [];
				this.trackers.push(new Interface.gef.tracker.DirectEditRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.ToolTracker(this));
				this.trackers.push(new Interface.gef.tracker.SelectionRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.CreateNodeRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.CreateEdgeRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.ResizeNodeRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.ResizeEdgeRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.MoveEdgeRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.MoveNodeRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.MoveTextRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.MarqueeRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.RemoveRequestTracker(this));
				this.trackers.push(new Interface.gef.tracker.SelectionListenerTracker(this))
			},
			initEvents : function($) {
				this.initMouseDownEvent($);
				this.initMouseMoveEvent($);
				this.initMouseUpEvent($);
				this.initDoubleClickEvent($);
				this.initKeyDownEvent($)
			},
			initMouseDownEvent : function(obj) {
				var $ = this, _ = function(A) {
					var _ = Interface.isIE ? event : A;
					$.mouseDown(_)
				};
				if(typeof obj != "undefined"){
					if (Interface.isIE)
						obj.attachEvent("onmousedown", _);
					else
						obj.addEventListener("mousedown", _, false)
				}else
				{
					if (Interface.isIE)
						document.attachEvent("onmousedown", _);
					else
						document.addEventListener("mousedown", _, false)
				}
			},
			initMouseMoveEvent : function(obj) {
				var $ = this, _ = function(A) {
					var _ = Interface.isIE ? event : A;
					$.mouseMove(_)
				};
				if(typeof obj != "undefined"){
					if (Interface.isIE)
						obj.attachEvent("onmousemove", _);
					else
						obj.addEventListener("mousemove", _, false)
				}else
				{
					if (Interface.isIE)
						document.attachEvent("onmousemove", _);
					else
						document.addEventListener("mousemove", _, false)
				}
			},
			initMouseUpEvent : function(obj) {
				var $ = this, _ = function(A) {
					var _ = Interface.isIE ? event : A;
					$.mouseUp(_)
				};
				if(typeof obj != "undefined"){
					if (Interface.isIE)
						obj.attachEvent("onmouseup", _);
					else
						obj.addEventListener("mouseup", _, false)
				}else
				{
					if (Interface.isIE)
						document.attachEvent("onmouseup", _);
					else
						document.addEventListener("mouseup", _, false)
				}
			},
			initDoubleClickEvent : function(obj) {
				var $ = this, _ = function(A) {
					var _ = Interface.isIE ? event : A;
					$.doubleClick(_)
				};
				if(typeof obj != "undefined"){
					if (Interface.isIE)
						obj.attachEvent("ondblclick", _);
					else
						obj.addEventListener("dblclick", _, false)
				}else
				{
					if (Interface.isIE)
						document.attachEvent("ondblclick", _);
					else
						document.addEventListener("dblclick", _, false)
				}
			},
			initKeyDownEvent : function(obj) {
				var $ = this, _ = function(A) {
					var _ = Interface.isIE ? event : A;
					$.keyDown(_)
				};
				if(typeof obj != "undefined"){
					if (Interface.isIE)
						obj.attachEvent("onkeydown", _);
					else
						obj.addEventListener("keydown", _, false)
				}else
				{
					if (Interface.isIE)
						document.attachEvent("onkeydown", _);
					else
						document.addEventListener("keydown", _, false)
				}
			},
			fireEvent : function(C, _) {
				if (this.enabled != true)
					return;
				var $ = this.getXY(_),
					B = this.getTarget(_),
					A = {
						e : _,
						eventName : C,
						point : $,
						target : B
					};
				try {
					Interface.each(this.trackers, function($) {
						if ($.understandRequest(A))
							$.processRequest(A)
					})
					if(C == "MOUSE_DOWN" && _.button == 2)
					{
						this.fireEvent("MOUSE_UP", _)
					}
				} catch (_) {
					console.error(_)
				}
				if (A.draggingType || A.selectType)
					this.stopEvent(_)
			},
			mouseDown : function($) {
				if(jQuery(".x-menu").length > 0){
					var index = jQuery(".x-menu").length -1;
					if(jQuery(jQuery(".x-menu")[index]).css("visibility") == 'visible')
					{
						return false;
					}
				}
				this.fireEvent("MOUSE_DOWN", $)
			},
			mouseMove : function($) {
				this.fireEvent("MOUSE_MOVE", $)
			},
			mouseUp : function($) {
				if(jQuery(".x-menu").length > 0){
					var index = jQuery(".x-menu").length -1;
					if(jQuery(jQuery(".x-menu")[index]).css("visibility") == 'visible')
					{
						return false;
					}
				}
				this.fireEvent("MOUSE_UP", $)
			},
			doubleClick : function($) {
				this.fireEvent("DBL_CLICK", $)
			},
			keyDown : function($) {
				this.fireEvent("KEY_DOWN", $)
			},
			getXY : function($) {
				var _ = {};
				if (typeof window.pageYOffset != "undefined")
				{
					_.x = window.pageXOffset;
					_.y = window.pageYOffset
				}
				else if (typeof document.compatMode != "undefined"
						 && document.compatMode != "BackCompat")
				{
					_.x = document.documentElement.scrollLeft;
					_.y = document.documentElement.scrollTop
				}
				else if (typeof document.body != "undefined")
				{
					_.x = document.body.scrollLeft;
					_.y = document.body.scrollTop
				}
				var C = this.graphicalViewer.getCanvasLocation(),
					B = $.clientX + _.x,
					A = $.clientY + _.y;
				return {
					x : B - C.x,
					y : A - C.y,
					absoluteX : B,
					absoluteY : A
				}
			},
			getTarget : function($) {
				return Interface.isIE ? $.srcElement : $.target
			},
			stopEvent : function($) {
				if (Interface.isIE)
					$.returnValue = false;
				else
					$.preventDefault()
			},
			getViewer : function() {
				return this.graphicalViewer
			},
			getSelectionManager : function() {
				return this.selectionManager
			},
			disable : function() {
				this.enabled = false
			},
			enable : function() {
				this.enabled = true
			}
		});
		Interface.gef.tracker.RequestTracker = Interface.extend(Object, {
			understandRequest : Interface.emptyFn,
			processRequest : Interface.emptyFn
		});
		Interface.gef.tracker.AbstractRequestTracker = Interface.extend(Interface.gef.tracker.RequestTracker, {
			constructor : function($) {
				this.browserListener = $;
				this.reset()
			},
			reset : function() {
				this.status = "NONE";
				this.temp = {}
			},
			getDraggingRect : function() {
				if (!this.draggingRect) {
					this.draggingRect = new Interface.figure.DraggingRectFigure({
																					x : -90,
																					y : -90,
																					w : 48,
																					h : 48
																				});
					this.getDraggingLayer().addChild(this.draggingRect);
					this.draggingRect.render()
				}
				return this.draggingRect
			},
			createDraggingRects : function() {
				if (!this.draggingRects)
					this.draggingRects = [];
				var $ = new Interface.figure.DraggingRectFigure({
																	x : -90,
																	y : -90,
																	w : 48,
																	h : 48
																});
				this.getDraggingLayer().addChild($);
				$.render();
				this.draggingRects.push($);
				return $
			},
			getDraggingRects : function($) {
				return this.draggingRects[$]
			},
			removeDraggingRects : function($) {
				Interface.each(this.draggingRects, function($) {
					$.remove()
				}, this);
				this.draggingRects = []
			},
			getDraggingEdge : function() {
				if (!this.draggingEdge) {
					this.draggingEdge = new Interface.figure.DraggingEdInterfaceigure({
																						  x1 : -1,
																						  y1 : -1,
																						  x2 : -1,
																						  y2 : -1
																					  });
					this.getDraggingLayer().addChild(this.draggingEdge);
					this.draggingEdge.render()
				}
				return this.draggingEdge
			},
			isInPalette : function($) {
				// if(Interface.Editor.ShowMode == Interface.ShowMode.MODE_READONLY)
				// {
				// 	return false
				// }else{
					return this.isIn($, this.getViewer().getPaletteLocation(), true)
				// }
			},
			isInCanvas : function($) {
				// if(Interface.Editor.ShowMode == Interface.ShowMode.MODE_READONLY)
				// {
				// 	return false
				// }else{
					return this.isIn($, this.getViewer().getCanvasLocation(), true)
				// }
			},
			isIn : function(_, A, $) {
				if ($ == true)
					return _.absoluteX > A.x && _.absoluteX < A.x + A.w
						   && _.absoluteY > A.y && _.absoluteY < A.y + A.h;
				else
					return _.x > A.x && _.x < A.x + A.w && _.y > A.y
						   && _.y < A.y + A.h
			},
			getPaletteConfig : function($) {
				return this.getViewer().getPaletteConfig($.point, $.target)
			},
			findEditPartAt : function(A) {
				var _ = A.point, C = this.getContents(), B = this
					.getNodeLayer().getChildren();
				for (var D = B.length - 1; D >= 0; D--) {
					var $ = B[D];
					if (this.isIn(_, $)) {
						C = this.getEditPartByFigure($);
						return C
					}
				}
				return C
			},
			getViewer : function() {
				return this.browserListener.getViewer()
			},
			getEditor : function() {
				return this.getViewer().getEditor()
			},
			getContents : function() {
				return this.getViewer().getContents()
			},
			getModelFactory : function() {
				return this.getEditor().getModelFactory()
			},
			getCommandStack : function() {
				return this.getViewer().getEditDomain().getCommandStack()
			},
			executeCommand : function(A, $) {
				var _ = A.getCommand($);
				if (_ != null)
					this.getCommandStack().execute(_)
			},
			getDraggingLayer : function() {
				return this.getViewer().getLayer("LAYER_DRAGGING")
			},
			getNodeLayer : function() {
				return this.getViewer().getLayer("LAYER_NODE")
			},
			getConnectionLayer : function() {
				return this.getViewer().getLayer("LAYER_CONNECTION")
			},
			getHandleLayer : function() {
				return this.getViewer().getLayer("LAYER_HANDLE")
			},
			getTargetEditPart : function() {
				return this.getContents()
			},
			getEditPartByFigure : function($) {
				return $.editPart
			},
			isConnection : function() {
				return this.getViewer().getActivePalette() != null && this.getViewer().getActivePalette().isConnection == true
			},
			notConnection : function() {
				return !this.isConnection()
			},
			getSelectionManager : function() {
				return this.browserListener.getSelectionManager()
			},
			getSelectedNodes : function() {
				return this.getSelectionManager().getSelectedNodes()
			},
			hasSelectedNoneOrOne : function() {
				return this.getSelectionManager().getSelectedCount() < 2
			},
			isMultiSelect : function($) {
				return $.e.ctrlKey == true
			},
			notMultiSelect : function($) {
				return !this.isMultiSelect($)
			},
			getConnectionByConnectionId : function(_) {
				var $ = null;
				Interface.each(this.getConnectionLayer().getChildren(), function(A) {
					if (_ == A.el.id)
						$ = A
				}, this);
				return $
			},
			getNodeByNodeId : function(_) {
				var $ = null;
				Interface.each(this.getNodeLayer().getChildren(), function(A) {
					if (_ == A.el.id)
						$ = A
				}, this);
				return $
			}
		});
		Interface.gef.tracker.SelectionManager = Interface.extend(Object, {
			constructor : function($) {
				this.items = [];
				this.handles = {};
				this.browserListener = $
			},
			addSelectedConnection : function($) {
				this.resizeEdgeHandle = new Interface.figure.ResizeEdgeHandle();
				this.resizeEdgeHandle.edge = $.getFigure();
				this.addHandle(this.resizeEdgeHandle);
				this.resizeEdgeHandle.render();
				this.selectedConnection = $
			},
			removeSelectedConnection : function($) {
				this.resizeEdgeHandle.remove();
				this.selectedConnection = null;
				this.resizeEdgeHandle = null
			},
			addSelectedNode : function(A, $) {
				if (this.items.length == 1 && this.items[0] == A)
					return false;
				if (!$)
					this.clearAll();
				var _ = this.items.indexOf(A) != -1;
				if (_) {
					if ($) {
						this.removeSelectedNode(A, $);
						return false
					}
				} else {
					this.items.push(A);
					this.createNodeHandle(A)
				}
				return true
			},
			removeSelectedNode : function(A, $) {
				var _ = this.items.indexOf(editPart) != -1;
				if (_) {
					this.items.remove(editPart);
					this.removeNodeHandle(editPart)
				}
			},
			clearAll : function() {
				Interface.each(this.items, function($) {
					this.removeNodeHandle($)
				}, this);
				this.items = [];
				if (this.selectedConnection != null)
					this.removeSelectedConnection(this.selectedEdge);
				if (this.draggingText != null)
					this.draggingText.hide()
			},
			selectAll : function() {
				this.clearAll();
				Interface.each(this.getNodes(), function($) {
					this.addSelectedNode($.editPart, true)
				}, this)
			},
			selectIn : function($) {
				this.clearAll();
				Interface.each(this.getNodes(), function(A) {
					var _ = A, C = _.x + _.w / 2, B = _.y + _.h / 2;
					if (C > $.x && C < $.x + $.w && B > $.y && B < $.y + $.h)
						this.addSelectedNode(A.editPart, true)
				}, this)
			},
			createNodeHandle : function(A) {
				var $ = A.getModel().getId(), _ = this.handles[$];
				if (!_) {
					_ = new Interface.figure.ResizeNodeHandle();
					this.handles[$] = _;
					_.node = A.getFigure();
					this.addHandle(_);
					_.render()
				}
				return _
			},
			removeNodeHandle : function(A) {
				var $ = A.getModel().getId(), _ = this.handles[$];
				if (_ != null) {
					_.remove();
					this.handles[$] = null;
					delete this.handles[$]
				}
				return _
			},
			refreshHandles : function() {
				for (var _ in this.handles) {
					var $ = this.handles[_];
					$.refresh()
				}
				if (this.resizeEdgeHandle)
					this.resizeEdgeHandle.refresh()
			},
			addHandle : function($) {
				var _ = this.browserListener.getViewer().getLayer("LAYER_HANDLE");
				_.addChild($)
			},
			addDragging : function(_) {
				var $ = this.browserListener.getViewer().getLayer("LAYER_DRAGGING");
				$.addChild(_)
			},
			getNodes : function() {
				var $ = this.browserListener.getViewer().getLayer("LAYER_NODE");
				return $.getChildren()
			},
			getSelectedNodes : function() {
				return this.items
			},
			getSelectedCount : function() {
				return this.items.length
			},
			getSelectedConnection : function() {
				return this.selectedConnection
			},
			getDefaultSelected : function() {
				return this.browserListener.getViewer().getContents()
			},
			getCurrentSelected : function() {
				if (this.selectedConnection)
					return [this.selectedConnection];
				else if (this.items.length > 0)
					return this.items;
				else
					return [this.getDefaultSelected()]
			},
			getDraggingText : function($) {
				if (!this.draggingText) {
					this.draggingText = new Interface.figure.DraggingTextFigure($);
					this.addDragging(this.draggingText);
					this.draggingText.render()
				}
				this.draggingText.edge = $;
				this.draggingText.show();
				return this.draggingText
			}
		});
		Interface.gef.tracker.CreateNodeRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			DRAGGING_CREATE_NODE : "DRAGGING_CREATE_NODE",
			understandRequest : function($) {
				if ($.editType != null)
					return false;
				if ($.draggingType != null)
					return false;
				if ($.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					if (this.isInPalette($.point)) {
						var _ = this.getPaletteConfig($);
						if (_ != null && _.creatable != false) {
							$.paletteConfig = _;
							$.draggingType = this.DRAGGING_CREATE_NODE;
							this.status = this.DRAGGING_CREATE_NODE
						}
					}
				} else if (($.eventName == "MOUSE_MOVE" || $.eventName == "MOUSE_UP")
						   && this.status != "NONE")
					$.draggingType = this.status;
				return $.draggingType == this.DRAGGING_CREATE_NODE
			},
			processRequest : function(_) {
				if (_.draggingType != this.DRAGGING_CREATE_NODE)
					return;
				if (_.eventName == "MOUSE_DOWN")
					this.drag(_);
				else if (_.eventName == "MOUSE_MOVE")
					this.move(_);
				else if (_.eventName == "MOUSE_UP") {
					if (this.isInCanvas(_.point)) {
						var $ = this.getDraggingRect(), A = $.name;
						_.role = {
							name : "CREATE_NODE",
							rect : {
								x : _.point.x - $.w / 2,
								y : _.point.y - $.h / 2,
								w : $.w,
								h : $.h
							},
							node : this.getModelFactory().createModel(A)
						};
						this.executeCommand(this.getTargetEditPart(), _)
					}
					this.drop(_);
					this.reset()
				}
			},
			drag : function(_) {
				var A = _.paletteConfig;
				this.getDraggingRect().name = A.text;
				var $ = A.w, C = A.h;
				if (isNaN($) || $ < 0)
					$ = 48;
				if (isNaN(C) || C < 0)
					C = 48;
				var D = $ * -1, B = C * -1;
				this.getDraggingRect().update(D, B, $, C)
			},
			move : function(A) {
				var $ = this.getDraggingRect(), _ = A.point, C = _.x - $.w / 2, B = _.y - $.h / 2;
				$.moveTo(C, B)
			},
			drop : function(_) {
				var $ = this.getDraggingRect(), B = $.w * -1, A = $.h * -1;
				$.moveTo(B, A)
			}
		});
		Interface.gef.tracker.CreateEdgeRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			DRAGGING_CREATE_EDGE : "DRAGGING_CREATE_EDGE",
			understandRequest : function($) {
				if ($.editType != null)
					return false;
				if ($.draggingType != null)
					return;
				if (!this.isInCanvas($.point) || this.notConnection())
					return;
				if ($.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					var _ = this.findEditPartAt($);
					if (_ != null && _.getClass() == "node")
						if (_.canCreateOutgo()) {
							this.temp.editPart = _;
							$.draggingType = this.DRAGGING_CREATE_EDGE;
							this.status = this.DRAGGING_CREATE_EDGE
						}
				} else if (($.eventName == "MOUSE_MOVE" || $.eventName == "MOUSE_UP") && this.status != "NONE")
					$.draggingType = this.status;
				return $.draggingType == this.DRAGGING_CREATE_EDGE
			},
			processRequest : function(A) {
				if (A.draggingType != this.DRAGGING_CREATE_EDGE)
					return;
				if (A.eventName == "MOUSE_DOWN")
					this.drag(A);
				else if (A.eventName == "MOUSE_MOVE")
					this.move(A);
				else if (A.eventName == "MOUSE_UP") {
					var _ = this.getDraggingEdge(), D = this.temp.editPart,
						B = this.findEditPartAt(A);
					if (D != B && B.getClass() == "node" && B.canCreateIncome()) {
						var $ = this.getViewer().getActivePalette().text,
							C = this.getModelFactory().createModel($);
						C.text = "to " + B.getModel().text;
						A.role = {
							name : "CREATE_EDGE",
							rect : {
								x1 : _.x1,
								y1 : _.y1,
								x2 : _.x2,
								y2 : _.y2
							},
							source : D.getModel(),
							target : B.getModel(),
							model : C
						};
						//开始节点不能直接连接判断节点 Jacky 2011 09 28
						if(A.role.source.type == 'start' && A.role.target.type == 'decision'){
							Interface.Event.trigger(Interface.EventMode.Alert,"开始节点不能直接连接判断节点。")
							return;
						}
						this.executeCommand(this.temp.editPart, A)
					}
					this.drop(A);
					this.reset()
				}
			},
			drag : function($) {
				this.getDraggingEdge().update(-1, -1, -1, -1)
			},
			move : function(B) {
				var A = B.point, $ = this.temp.editPart.getFigure(),
					C = {
					x : $.x,
					y : $.y,
					w : $.w,
					h : $.h
				}, _ = this.getDraggingEdge();
				_.updateForDragging(C, A)
			},
			drop : function($) {
				this.getDraggingEdge().moveToHide()
			}
		});
		Interface.gef.tracker.MoveNodeRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			DRAGGING_MOVE_NODE : "DRAGGING_MOVE_NODE",
			understandRequest : function($) {
				if ($.editType != null)
					return false;
				if ($.draggingType != null)
					return;
				if (!this.isInCanvas($.point) || this.isConnection())
					return;
				if ($.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					var _ = this.findEditPartAt($);
					if (_ != null && _.getClass() == "node") {
						this.temp = {
							x : $.point.x,
							y : $.point.y,
							editPart : _
						};
						$.draggingType = this.DRAGGING_MOVE_NODE;
						this.status = this.DRAGGING_MOVE_NODE
					}
				} else if (($.eventName == "MOUSE_MOVE" || $.eventName == "MOUSE_UP") && this.status != "NONE")
					$.draggingType = this.status;
				return $.draggingType == this.DRAGGING_MOVE_NODE
			},
			processRequest : function(A) {
				if (A.draggingType != this.DRAGGING_MOVE_NODE)
					return;
				if (A.eventName == "MOUSE_DOWN") {
					if (this.notMultiSelect(A) && this.hasSelectedNoneOrOne()) {
						var B = this.findEditPartAt(A);
						this.getSelectionManager().addSelectedNode(B)
					}
					this.drag(A)
				} else if (A.eventName == "MOUSE_MOVE")
					this.move(A);
				else if (A.eventName == "MOUSE_UP") {
					var $ = this.getDraggingRect(), _ = [];
					Interface.each(this.getSelectedNodes(), function($) {
						_.push($.getModel())
					});
					if (A.point.x != this.temp.x || A.point.y != this.temp.y) {
						A.role = {
							name : "MOVE_NODE",
							nodes : _,
							dx : A.point.x - this.temp.x,
							dy : A.point.y - this.temp.y
						};
						this.executeCommand(this.getContents(), A);
						this.getSelectionManager().refreshHandles()
					} else
						A.draggingType = "DRAGGING_MOVE_NODE_WITHOUT_MOVE";
					this.drop(A);
					this.reset()
				}
			},
			drag : function($) {
				Interface.each(this.getSelectedNodes(), function(B) {
					var A = B.getFigure(), _ = A.w, D = A.h, E = A.x + $.point.x - this.temp.x,
						C = A.y + $.point.y - this.temp.y;
					this.createDraggingRects().update(_ * -1, D * -1, _, D)
				}, this);
				this.browserListener.dragging = true
			},
			move : function($) {
				Interface.each(this.getSelectedNodes(), function(C, A) {
					var _ = this.getDraggingRects(A), B = C.getFigure(),
						E = B.x + $.point.x - this.temp.x, D = B.y + $.point.y - this.temp.y;
					_.moveTo(E, D)
				}, this)
			},
			drop : function($) {
				this.removeDraggingRects();
				this.browserListener.dragging = false
			}
		});
		Interface.gef.tracker.MoveEdgeRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			DRAGGING_MOVE_EDGE : "DRAGGING_MOVE_EDGE",
			understandRequest : function(C) {
				if (C.editType != null)
					return false;
				if (C.draggingType != null)
					return false;
				if (!this.isInCanvas(C.point))
					return false;
				if (C.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					var D = C.target;
					if (D.id.indexOf(":")) {
						var E = D.id.split(":"), A = E[0], B = E[1];
						if (B != "start" && B != "end")
							return false;
						var _ = this.getConnectionByConnectionId(A);
						if (_ == null || _ == undefined)
							return false;
						var $ = this.getSelectionManager().resizeEdgeHandle;
						if ($ == null || $ == undefined)
							return false;
						this.temp = {
							editPart : _.editPart,
							handle : $,
							direction : B
						};
						C.draggingType = this.DRAGGING_MOVE_EDGE;
						this.status = this.DRAGGING_MOVE_EDGE
					}
				} else if ((C.eventName == "MOUSE_MOVE" || C.eventName == "MOUSE_UP") && this.status != "NONE")
					C.draggingType = this.status;
				return C.draggingType == this.DRAGGING_MOVE_EDGE
			},
			processRequest : function(C) {
				if (C.draggingType != this.DRAGGING_MOVE_EDGE)
					return;
				if (C.eventName == "MOUSE_DOWN")
					this.drag(C);
				else if (C.eventName == "MOUSE_MOVE")
					this.move(C);
				else if (C.eventName == "MOUSE_UP") {
					var B = this.getDraggingEdge(), E = this.findEditPartAt(C), _ = this.temp.editPart;
					if (E.getClass() == "node") {
						var A = this.temp.direction;
						if ((A == "start" && E.canCreateOutgo())
							|| (A == "end" && E.canCreateIncome())) {
							var $ = null, D = null;
							if (A == "start") {
								$ = E.getModel();
								D = _.target.getModel()
							} else {
								$ = _.source.getModel();
								D = E.getModel()
							}
							C.role = {
								name : "MOVE_EDGE",
								rect : {
									x1 : B.x1,
									y1 : B.y1,
									x2 : B.x2,
									y2 : B.y2
								},
								source : $,
								target : D
							};
							this.executeCommand(_, C)
						}
					}
					this.drop(C);
					this.reset()
				}
			},
			drag : function(C) {
				var B = C.point, _ = this.temp.direction, D = this.temp.editPart, $ = null;
				if (_ == "start")
					$ = D.getTarget().getFigure();
				else
					$ = D.getSource().getFigure();
				var E = {
					x : $.x,
					y : $.y,
					w : $.w,
					h : $.h
				}, A = this.getDraggingEdge();
				A.updateForMove(D.getFigure(), _, B)
			},
			move : function(C) {
				var B = C.point, _ = this.temp.direction, D = this.temp.editPart, $ = null;
				if (_ == "start")
					$ = D.target.figure;
				else
					$ = D.source.figure;
				var E = {
					x : $.x,
					y : $.y,
					w : $.w,
					h : $.h
				}, A = this.getDraggingEdge();
				A.updateForMove(D.getFigure(), _, B)
			},
			drop : function($) {
				this.getDraggingEdge().moveToHide()
			}
		});
		Interface.gef.tracker.MoveTextRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			DRAGGING_MOVE_TEXT : "DRAGGING_MOVE_TEXT",
			understandRequest : function(B) {
				if (B.editType != null)
					return false;
				if (B.draggingType != null) {
					if (this.draggingText != null)
						this.draggingText.hide();
					return
				}
				if (!this.isInCanvas(B.point))
					return;
				if (B.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					var _ = B.target, A = _.getAttribute("edgeId");
					if (A != null)
						if (_.tagName == "text" || _.tagName == "textbox") {
							var $ = this
								.getConnectionByConnectionId(A);
							if ($ == null)
								return;
							this.temp = {
								editPart : $.editPart,
								x : B.point.x,
								y : B.point.y
							};
							B.draggingType = this.DRAGGING_MOVE_TEXT;
							this.status = this.DRAGGING_MOVE_TEXT
						}
				} else if ((B.eventName == "MOUSE_MOVE" || B.eventName == "MOUSE_UP") && this.status != "NONE")
					B.draggingType = this.status;
				return B.draggingType == this.DRAGGING_MOVE_TEXT
			},
			processRequest : function(A) {
				if (A.draggingType != this.DRAGGING_MOVE_TEXT)
					return;
				if (A.eventName == "MOUSE_DOWN") {
					this.getSelectionManager().clearAll();
					this.drag(A)
				} else if (A.eventName == "MOUSE_MOVE")
					this.move(A);
				else if (A.eventName == "MOUSE_UP") {
					var C = this.temp.oldX, B = this.temp.oldY,
						_ = C + A.point.x - this.temp.x,
						$ = B + A.point.y - this.temp.y;
					A.role = {
						name : "MOVE_TEXT",
						oldTextX : C,
						oldTextY : B,
						newTextX : _,
						newTextY : $,
						edge : this.temp.editPart
					};
					this.executeCommand(this.temp.editPart, A);
					this.drop(A);
					this.reset()
				}
			},
			drag : function(_) {
				var $ = this.getDraggingText();
				$.refresh();
				this.temp.oldX = $.edge.textX;
				this.temp.oldY = $.edge.textY
			},
			move : function(B) {
				var A = this.getDraggingText(), $ = B.point.x - this.temp.x,
					_ = B.point.y - this.temp.y;
				A.edge.textX = this.temp.oldX + $;
				A.edge.textY = this.temp.oldY + _;
				A.refresh()
			},
			drop : function($) {
			},
			getDraggingText : function() {
				var $ = this.temp.editPart.getFigure();
				return this.getSelectionManager().getDraggingText($)
			}
		});
		Interface.gef.tracker.ResizeNodeRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			DRAGGING_RESIZE_NODE : "DRAGGING_RESIZE_NODE",
			understandRequest : function(C) {
				if (C.editType != null)
					return false;
				if (C.draggingType != null)
					return false;
				if (!this.isInCanvas(C.point))
					return false;
				if (C.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					var D = C.target;
					if (D.id.indexOf(":")) {
						var F = D.id.split(":"), _ = F[0], B = F[1], $ = this
							.getNodeByNodeId(_);
						if ($ == null || $ == undefined)
							return false;
						else if (!$.editPart.canResize())
							return false;
						var E = this.getSelectionManager().handles,
							A = E[$.editPart.getModel().getId()];
						if (A == null || A == undefined)
							return false;
						this.temp = {
							editPart : $.editPart,
							handle : A,
							direction : B
						};
						C.draggingType = this.DRAGGING_RESIZE_NODE;
						this.status = this.DRAGGING_RESIZE_NODE
					}
				} else if ((C.eventName == "MOUSE_MOVE" || C.eventName == "MOUSE_UP")&& this.status != "NONE")
					C.draggingType = this.status;
				return C.draggingType == this.DRAGGING_RESIZE_NODE
			},
			processRequest : function(A) {
				if (A.draggingType != this.DRAGGING_RESIZE_NODE)
					return;
				if (A.eventName == "MOUSE_DOWN")
					this.drag(A);
				else if (A.eventName == "MOUSE_MOVE")
					this.move(A);
				else if (A.eventName == "MOUSE_UP") {
					var _ = this.getDraggingRect(), B = this.temp.editPart, E = this.temp.rect.x, D = this.temp.rect.y, $ = this.temp.rect.w, C = this.temp.rect.h;
					if ($ < 0)
						$ = 5;
					if (C < 0)
						C = 5;
					A.role = {
						name : "RESIZE_NODE",
						rect : {
							x : E,
							y : D,
							w : $,
							h : C
						},
						node : B.getModel()
					};
					this.executeCommand(B, A);
					this.temp.handle.refresh();
					this.drop(A);
					this.reset()
				}
			},
			drag : function(_) {
				var A = this.temp.editPart.figure, $ = this.temp.direction;
				if ($ == "n") {
					this.temp.x = A.x + A.w / 2;
					this.temp.y = A.y
				} else if ($ == "s") {
					this.temp.x = A.x + A.w / 2;
					this.temp.y = A.y + A.h
				} else if ($ == "w") {
					this.temp.x = A.x;
					this.temp.y = A.y + A.h / 2
				} else if ($ == "e") {
					this.temp.x = A.x + A.w;
					this.temp.y = A.y + A.h / 2
				} else if ($ == "nw") {
					this.temp.x = A.x;
					this.temp.y = A.y
				} else if ($ == "ne") {
					this.temp.x = A.x + A.w;
					this.temp.y = A.y
				} else if ($ == "sw") {
					this.temp.x = A.x;
					this.temp.y = A.y + A.h
				} else if ($ == "se") {
					this.temp.x = A.x + A.w;
					this.temp.y = A.y + A.h
				}
				this.getDraggingRect().update(A.x, A.y, A.w, A.h)
			},
			move : function(G) {
				var H = G.point, F = this.temp.editPart.getFigure(), A = this.temp.direction, J = F.x, I = F.y, D = F.w, C = F.h, $ = H.x
																																	  - this.temp.x, _ = H.y - this.temp.y;
				if (A == "n") {
					I = I + _;
					C = C - _
				} else if (A == "s")
					C = C + _;
				else if (A == "w") {
					J = J + $;
					D = D - $
				} else if (A == "e")
					D = D + $;
				else if (A == "nw") {
					J = J + $;
					D = D - $;
					I = I + _;
					C = C - _
				} else if (A == "ne") {
					D = D + $;
					I = I + _;
					C = C - _
				} else if (A == "sw") {
					J = J + $;
					D = D - $;
					C = C + _
				} else if (A == "se") {
					D = D + $;
					C = C + _
				}
				var B = {
					x : J,
					y : I,
					w : D,
					h : C
				};
				this.temp.rect = B;
				var E = this.getDraggingRect();
				E.update(B.x, B.y, B.w, B.h)
			},
			drop : function($) {
				this.getDraggingRect().update(-1, -1, 1, 1)
			}
		});
		Interface.gef.tracker.ResizeEdgeRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			DRAGGING_RESIZE_EDGE : "DRAGGING_RESIZE_EDGE",
			understandRequest : function(J) {
				if (J.editType != null)
					return false;
				if (J.draggingType != null)
					return;
				if (!this.isInCanvas(J.point))
					return;
				if (J.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					var K = J.target, F = K.id;
					if (F != null && F.indexOf(":middle:") != -1) {
						var I = F.substring(0, F.indexOf(":middle:")), _ = this
							.getConnectionByConnectionId(I);
						if (_ == null || _ == undefined)
							return;
						var $ = F.substring(F.indexOf(":middle:")
											+ ":middle:".length).split(","), C = parseInt(
							$[0], 10), G = parseInt($[1], 10), D = this
							.getSelectionManager().resizeEdgeHandle, A = [];
						Interface.each(_.innerPoints, function($) {
							A.push([$[0], $[1]])
						});
						var H = null, E = null, B = null;
						if (C == G) {
							H = _.innerPoints[C];
							if (C == 0)
								E = [_.x1, _.y1];
							else
								E = _.innerPoints[C - 1];
							if (G == _.innerPoints.length - 1)
								B = [_.x2, _.y2];
							else
								B = _.innerPoints[C + 1]
						} else {
							if (C == -1)
								E = [_.x1, _.y1];
							else
								E = _.innerPoints[C];
							if (G >= _.innerPoints.length)
								B = [_.x2, _.y2];
							else
								B = _.innerPoints[G];
							H = [(E[0] + B[0]) / 2, (E[1] + B[1]) / 2];
							_.innerPoints.splice(C + 1, 0, H);
							D.modify()
						}
						this.temp = {
							editPart : _.editPart,
							point : H,
							x : H[0],
							y : H[1],
							oldX : J.point.x,
							oldY : J.point.y,
							prevIndex : C,
							nextIndex : G,
							prev : E,
							next : B,
							oldInnerPoints : A
						};
						J.draggingType = this.DRAGGING_RESIZE_EDGE;
						this.status = this.DRAGGING_RESIZE_EDGE
					}
				} else if ((J.eventName == "MOUSE_MOVE" || J.eventName == "MOUSE_UP") && this.status != "NONE")
					J.draggingType = this.status;
				return J.draggingType == this.DRAGGING_RESIZE_EDGE
			},
			processRequest : function($) {
				if ($.draggingType != this.DRAGGING_RESIZE_EDGE)
					return;
				if ($.eventName == "MOUSE_DOWN")
					this.drag($);
				else if ($.eventName == "MOUSE_MOVE")
					this.move($);
				else if ($.eventName == "MOUSE_UP") {
					var _ = this.temp.editPart;
					if (this.isSameLine($.point.x, $.point.y,
										this.temp.prev[0], this.temp.prev[1],
										this.temp.next[0], this.temp.next[1]))
						_.getFigure().innerPoints
						 .splice(this.temp.nextIndex, 1);
					$.role = {
						name : "RESIZE_EDGE",
						rect : {
							x : _.figure.x,
							y : _.figure.y,
							w : _.figure.w,
							h : _.figure.h
						},
						oldInnerPoints : this.temp.oldInnerPoints,
						newInnerPoints : _.getFigure().innerPoints
					};
					this.executeCommand(_, $);
					var A = this.getSelectionManager().resizeEdgeHandle;
					A.modify();
					this.drop($);
					this.reset()
				}
			},
			drag : function($) {
			},
			move : function(A) {
				var $ = A.point.x - this.temp.oldX, _ = A.point.y - this.temp.oldY;
				this.temp.point[0] = this.temp.x + $;
				this.temp.point[1] = this.temp.y + _;
				var B = this.getSelectionManager().resizeEdgeHandle;
				B.modify()
			},
			drop : function($) {
			},
			isSameLine : function(J, A, K, C, G, D) {
				var E = new Interface.Geom.Line(K, C, G, D), B = 0;
				if (C == D)
					B = Math.abs(A - C);
				else {
					var I = E.getK(), _ = E.getD(), $ = -1 / I,
						M = A - $ * J, H = (_ - M) / ($ - I), F = I * H + _;
					B = Math.sqrt((J - H) * (J - H) + (A - F) * (A - F))
				}
				return B < 10
			}
		});
		Interface.gef.tracker.MarqueeRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			DRAGGING_MARQUEE : "DRAGGING_MARQUEE",
			understandRequest : function(_) {
				if (_.editType != null)
					return false;
				if (_.draggingType != null)
					return;
				if (!this.isInCanvas(_.point))
					return;
				if (_.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					if (this.isInCanvas(_.point)) {
						var $ = _.target;
						if ((Interface.isVml && $.tagName == "DIV") || (Interface.isSvg && $.tagName == "svg")) {
							_.draggingType = this.DRAGGING_MARQUEE;
							this.status = this.DRAGGING_MARQUEE
						}
					}
				} else if ((_.eventName == "MOUSE_MOVE" || _.eventName == "MOUSE_UP") && this.status != "NONE")
					_.draggingType = this.status;
				return _.draggingType == this.DRAGGING_MARQUEE
			},
			processRequest : function(_) {
				if (_.draggingType != this.DRAGGING_MARQUEE)
					return;
				if (_.eventName == "MOUSE_DOWN")
					this.drag(_);
				else if (_.eventName == "MOUSE_MOVE")
					this.move(_);
				else if (_.eventName == "MOUSE_UP") {
					var A = this.getDraggingRect(), $ = {
						x : _.point.x < A.x ? _.point.x : A.x,
						y : _.point.y < A.y ? _.point.y : A.y,
						w : A.w,
						h : A.h
					};
					this.getSelectionManager().selectIn($);
					this.drop(_);
					this.reset()
				}
			},
			drag : function(_) {
				var $ = _.point;
				this.getDraggingRect().update($.x, $.y, 0, 0)
			},
			move : function(A) {
				var $ = this.getDraggingRect(), _ = A.point;
				$.update($.x, $.y, _.x - $.x, _.y - $.y)
			},
			drop : function($) {
				this.getDraggingRect().update(-90, -90, 100, 60)
			}
		});
		Interface.gef.tracker.DirectEditRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			understandRequest : function(_) {
				if (this.status != "NONE")
					_.editType = this.status;
				if (this.isInCanvas(_.point) && _.eventName == "DBL_CLICK")
					if (_.target.tagName == "text"
						|| _.target.tagName == "textbox") {
						_.editType = "EDIT_START";
						this.status = "EDIT_START"
					}
				if (_.eventName == "MOUSE_DOWN" && _.target.tagName != "INPUT")
					if (this.status == "ALREADY_START_EDIT") {
						_.editType = "EDIT_COMPLETE";
						this.status = "EDIT_COMPLETE"
					}
				if (_.eventName == "KEY_DOWN") {
					var $ = _.e.keyCode;
					if ($ == 10 || $ == 13) {
						_.editType = "EDIT_COMPLETE";
						this.status = "EDIT_COMPLETE"
					}
					if ($ == 27) {
						_.editType = "EDIT_CANCEL";
						this.status = "EDIT_CANCEL"
					}
				}
				return _.editType == "EDIT_START"
					   || _.editType == "ALREADY_START_EDIT"
					   || _.editType == "EDIT_CANCEL"
					   || _.editType == "EDIT_COMPLETE"
			},
			processRequest : function($) {
				if (!$.editType)
					return;
				if ($.editType == "EDIT_START")
					this.startEdit($);
				else if ($.editType == "EDIT_COMPLETE")
					this.completeEdit($);
				else if ($.editType == "EDIT_CANCEL")
					this.cancelEdit($)
			},
			startEdit : function(A) {
				var B = this.findEditPartAt(A);
				if (B.getClass() == "node") {
					if (B.getFigure().updateAndShowText != null) {
						this.getTextEditor().showForNode(B.getFigure());
						this.temp.editPart = B;
						this.status = "ALREADY_START_EDIT"
					} else
						this.status = "NONE"
				} else if (this.isText(A.target)) {
					var _ = A.target.getAttribute("edgeId"), $ = this.getConnectionByConnectionId(_);
					if($ != null){//JACKY -------------
						this.getTextEditor().showForEdge($);
						this.temp.editPart = $.editPart;
					}
					this.status = "ALREADY_START_EDIT"
				}
			},
			completeEdit : function(A) {
				if (!this.temp.editPart)
					return;
				var B = this.temp.editPart, $ = this.getTextEditor().getValue().trim();
				if ($ != B.getModel().name) {
					A.role = {
						name : "EDIT_TEXT",
						text : $
					};
					this.executeCommand(B, A)
				}
				this.getTextEditor().hide();
				var _ = this.getSelectionManager().draggingText;
				if (_)
					_.refresh();
				this.reset()
			},
			cancelEdit : function($) {
				this.getTextEditor().hide();
				this.reset()
			},
			isText : function($) {
				return (Interface.isVml && $.tagName == "textbox") || (Interface.isSvg && $.tagName == "text")
			},
			getTextEditor : function() {
				var A = this.browserListener.getViewer().getCanvasLocation();
				var _ = A.x, $ = A.y;
				if(typeof Interface.parent != "undefined")
				{
					var B = this.browserListener.getViewer().getPaletteLocation();
					var C = this.browserListener.getViewer().getCanvasClientLocation();
					_ = Interface.parent.offsetLeft + B.w + 5 - C.sl;
					$ = Interface.parent.offsetTop + (Interface.parent.offsetHeight - C.ch - C.st) - C.sbw + 1;
				}
				if (!this.textEditor) {
					this.textEditor = new Interface.figure.TextEditor(_, $)
				}
				this.textEditor.baseX = _;
				this.textEditor.baseY = $;
				this.textEditor.show();
				return this.textEditor
			}
		});
		Interface.gef.tracker.RemoveRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			understandRequest : function($) {
				if ($.editType != null)
					return false;
				if ($.eventName != "KEY_DOWN")
					return;
				$.removeType = "REMOVE";
				return $.removeType == "REMOVE"
			},
			processRequest : function(_) {
				if (_.removeType != "REMOVE")
					return;
				if (_.eventName == "KEY_DOWN") {
					var $ = _.e.keyCode;
					if ($ == 46) {
						_.removeType = "REMOVE";
						this.status = "REMOVE";
						this.removeAll(_)
					}
					if (_.e.ctrlKey && $ == 65) {
						_.removeType = "SELECT_ALL";
						this.status = "SELECT_ALL";
						this.selectAllNodes(_)
					}
				}
			},
			removeAll : function(C) {
				try {
					var $ = this.getSelectionManager(), A = $.selectedConnection, B = $.items;
					if (A != null) {
						C.role = {
							name : "REMOVE_EDGE"
						};
						this.executeCommand(A, C);
						$.removeSelectedConnection()
					} else if (B.length > 0) {
						C.role = {
							name : "REMOVE_NODES",
							nodes : B
						};
						this.executeCommand(
							this.browserListener.graphicalViewer
								.getContents(), C);
						$.clearAll()
					}
				} catch (_) {
					console.error(_)
				}
			},
			selectAllNodes : function($) {
				this.getSelectionManager().selectAll()
			}
		});
		Interface.gef.tracker.SelectionRequestTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			understandRequest : function($) {
				if ($.editType != null)
					return false;
				if ($.draggingType != null)
					return false;
				if ($.eventName != "MOUSE_UP" || !this.isInCanvas($.point))
					return false;
				if (this.browserListener.dragging == true)
					return false;
				$.selectType = "SELECT";
				return $.selectType == "SELECT"
			},
			processRequest : function(A) {
				if (A.selectType != "SELECT")
					return;
				var B = this.findEditPartAt(A);
				if (B.getClass() == "process")
					;
				else if (B.getClass() == "node") {
					var _ = this.addSelected(B, this.isMultiSelect(A));
					if (_) {
						var $ = this.createNodeHandle(B);
						$.refresh()
					}
				} else if (B.getClass() == "connection") {
					this.clearAll();
					this.addSelectedEdge(B)
				}
			},
			addSelectedEdge : function($) {
				this.getSelectionManager().addSelectedConnection($)
			},
			removeSelectedEdge : function($) {
				this.getSelectionManager().removeSelectedConnection($)
			},
			addSelected : function(_, $) {
				return this.getSelectionManager().addSelectedNode(_, $)
			},
			removeSelected : function(_, $) {
				this.getSelectionManager().removeSelectedNode(_, $)
			},
			clearAll : function() {
				this.getSelectionManager().clearAll()
			},
			selectAll : function() {
				this.getSelectionManager().selectAll()
			},
			selectIn : function($) {
				this.getSelectionManager().selectIn($)
			},
			createNodeHandle : function($) {
				return this.getSelectionManager().createNodeHandle($)
			},
			removeNodeHandle : function($) {
				return this.getSelectionManager.removeNodeHandle($)
			},
			refreshHandles : function() {
				this.getSelectionManager.refreshHandles()
			},
			findEditPartAt : function(_) {
				var $ = _.point, A = this.getContents();
				Interface.each(this.getNodeLayer().getChildren(), function(_) {
					if (this.isIn($, _)) {
						A = this.getEditPartByFigure(_);
						return false
					}
				}, this);
				Interface.each(this.getConnectionLayer().getChildren(), function($) {
					if (_.target.id == $.el.id) {
						A = this.getEditPartByFigure($);
						return false
					}
				}, this);
				return A
			}
		});
		Interface.gef.tracker.SelectionListener = Interface.extend(Object, {
			selectionChanged : Interface.emptyFn
		});
		Interface.gef.tracker.SelectionListenerTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			understandRequest : function($) {
				return $.eventName == "MOUSE_UP" || $.eventName == "KEY_DOWN"
			},
			processRequest : function(B) {
				var $ = this.getSelectionManager();
				if (!this.previousSelected)
					this.previousSelected = [$.getDefaultSelected()];
				var A = $.getCurrentSelected(), _ = $.getDefaultSelected(), C = false;
				if (this.previousSelected.length == A.length) {
					for (var D = 0; D < A.length; D++)
						if (A[D] != this.previousSelected[D]) {
							C = true;
							break
						}
				} else
					C = true;
				if (C == true) {
					Interface.each(this.getSelectionListeners(), function($) {
						$.selectionChanged(A, this.previousSelected, _)
					});
					this.previousSelected = A
				}
			},
			getSelectionListeners : function() {
				if (!this.selectionListeners)
					this.selectionListeners = [];
				return this.selectionListeners
			},
			addSelectionListener : function($) {
				this.getSelectionListeners().push($)
			}
		});
		Interface.gef.tracker.DefaultSelectionListener = Interface.extend(Interface.gef.tracker.SelectionListener, {
			selectionChanged : function(A, $, _) {
				if (A.length == 1) {
					var B = A[0];
					if (B == _)
						this.selectDefault(_);
					else if (B.getClass() == "node")
						this.selectNode(B);
					else
						this.selectConnection(B)
				} else
					this.selectDefault(_)
			},
			selectNode : Interface.emptyFn,
			selectConnection : Interface.emptyFn,
			selectDefault : Interface.emptyFn
		});
		Interface.gef.tracker.ToolTracker = Interface.extend(Interface.gef.tracker.AbstractRequestTracker, {
			isTool : function(_) {
				var $ = false, A = null;
				Interface.each(this.getSelectedNodes(), function(B) {
					Interface.each(B.getFigure().getTools(), function(B) {
						if (B.isClicked(_)) {
							$ = true;
							A = B;
							return false
						}
						if ($ == true)
							return false
					})
				});
				if ($ == true)
					this.selectedTool = A;
				return $
			},
			understandRequest : function($) {
				if ($.editType != null)
					return false;
				if ($.draggingType != null)
					return false;
				if ($.eventName == "MOUSE_DOWN" && this.status == "NONE") {
					if (this.isTool($)) {
						this.status = "TOOL_SELECTED";
						this.draggingType = this.status;
						return true
					}
				} else if ($.eventName == "MOUSE_MOVE") {
					if (this.status == "TOOL_SELECTED") {
						this.status = "TOOL_MOVE";
						this.draggingType = this.status;
						return true
					} else if (this.status == "TOOL_MOVE")
						return true
				} else if ($.eventName == "MOUSE_UP")
					if (this.status == "TOOL_MOVE") {
						this.status = "TOOL_DROP";
						this.draggingType = this.status;
						return true
					} else if (this.status == "TOOL_DROP")
						return true;
				return false
			},
			processRequest : function($) {
				if (!this.status)
					return;
				if (this.status == "TOOL_SELECTED")
					this.drag($);
				else if (this.status == "TOOL_MOVE")
					this.move($);
				else if (this.status == "TOOL_DROP")
					this.drop($)
			},
			drag : function($) {
				this.selectedTool.drag(this)
			},
			move : function($) {
				this.selectedTool.move(this, $)
			},
			drop : function($) {
				this.selectedTool.drop(this, $);
				this.reset()
			}
		});
	},
	//初始化编辑器模型接口
	initEditorPort : function(Interface) {
		Interface.ns("Interface.simple.editpart");
		Interface.simple.editpart.ProcessEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				return new Interface.simple.figure.ProcessFigure()
			},
			getClass : function() {
				return "process"
			},
			canCreate : function($) {
				var _ = true;
				if ($.getType() == "start"){
					Interface.each(this.children, function($) {
						if ($.getModel().type == "start") {
							Interface.Event.trigger(Interface.EventMode.Alert,"一个流程只能有一个开始节点")
							_ = false;
							return false
						}
					});
				}else if ($.getType() == "end"){
					Interface.each(this.children, function($) {
						if ($.getModel().type == "end") {
							Interface.Event.trigger(Interface.EventMode.Alert,"一个流程图中只允许有一个结束节点！")
							_ = false;
							return false
						}
					});
				}else if ($.getType() == "endCancel"){
					Interface.each(this.children, function($) {
						if ($.getModel().type == "endCancel") {
							Interface.Event.trigger(Interface.EventMode.Alert,"一个流程图中只允许有一个中止节点！")
							_ = false;
							return false
						}
					});
				}
				return _;
			}
		});
		//新增的节点入口：开始
		Interface.simple.editpart.StartEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var _ = new Interface.simple.figure.StartFigure({
															  x : this.model.x,
															  y : this.model.y,
															  name : this.model.text
														  });
				_.editPart = this;
				return _
			},
			canCreateOutgo : function() {
				if (this.getSourceConnections().length == 0)
					return true;
				else {
					Interface.Event.trigger(Interface.EventMode.Alert,"开始节点只能有一个出边。")
					return false
				}
			},
			canCreateIncome : function() {
				Interface.Event.trigger(Interface.EventMode.Alert,"不能指向开始节点。")
				return false
			},
			canResize : function() {
				return false
			}
		});
		//新增的节点入口：结束
		Interface.simple.editpart.EndEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var j=0;
				for(var i=0;  i<this.parent.children.length; i++){
					if(this.parent.children[i].model.type == 'end'){
						j++;
						if(j>=2){
							Interface.Event.trigger(Interface.EventMode.Alert,"一个流程图中只允许有一个结束节点！")
							return this.getModel();
						}
					}
				}
				if(j<=1){
					var _ = new Interface.simple.figure.EndFigure({
																x : this.model.x,
																y : this.model.y,
																name : this.model.text
															});
					_.editPart = this;
					return _;
				}
			},
			canCreateOutgo : function() {
				Interface.Event.trigger(Interface.EventMode.Alert,"结束节点不能有任何出边")
				return false
			},
			canResize : function() {
				return false
			}
		});
		//新增的节点入口：中止
		Interface.simple.editpart.EndCancelEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var j=0;
				for(var i=0;  i<this.parent.children.length; i++){
					if(this.parent.children[i].model.type == 'endCancel'){
						j++;
						if(j>=2){
							Interface.Event.trigger(Interface.EventMode.Alert,"一个流程图中只允许有一个中止节点！")
							return this.getModel();
						}
					}
				}
				if(j<=1){
					var _ = new Interface.simple.figure.EndCancelFigure({
																	  x : this.model.x,
																	  y : this.model.y,
																	  name : this.model.text
																  });
					_.editPart = this;
					return _;
				}
			},
			canCreateOutgo : function() {
				Interface.Event.trigger(Interface.EventMode.Alert,"中止节点不能有任何出边")
				return false
			},
			canResize : function() {
				return false
			}
		});
		//新增的节点入口：任务
		Interface.simple.editpart.TaskEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var _ = new Interface.simple.figure.TaskFigure({
															 x : this.model.x,
															 y : this.model.y,
															 name : this.model.text
														 });
				_.editPart = this;
				return _
			}
		});
		//新增的节点入口：状态
		Interface.simple.editpart.StateEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var _ = new Interface.simple.figure.StateFigure({
															  x : this.model.x,
															  y : this.model.y,
															  name : this.model.text
														  });
				_.editPart = this;
				return _
			}
		});
		//新增的节点入口: 分支
		Interface.simple.editpart.ForkEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var _ = new Interface.simple.figure.ForkFigure({
															 x : this.model.x,
															 y : this.model.y,
															 name : this.model.text
														 });
				_.editPart = this;
				return _
			},
			canCreateIncome : function() {
				if(this.getTargetConnections().length == 0){
					return true;
				}else{
					Interface.Event.trigger(Interface.EventMode.Alert,"分散节点只能有一个入边。")
					return false
				}
			},
			canResize : function() {
				return false
			}
		});
		//新增的节点入口: 合并
		Interface.simple.editpart.JoinEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var _ = new Interface.simple.figure.JoinFigure({
															 x : this.model.x,
															 y : this.model.y,
															 name : this.model.text
														 });
				_.editPart = this;
				return _
			},
			canCreateOutgo : function() {
				if (this.getSourceConnections().length == 0)
					return true;
				else {
					Interface.Event.trigger(Interface.EventMode.Alert,"合并节点只能有一个出边。")
					return false
				}
			},
			canResize : function() {
				return false
			}
		});
		//新增的节点入口: 判断
		Interface.simple.editpart.DecisionEditPart = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var _ = new Interface.simple.figure.DecisionFigure({
																 x : this.model.x,
																 y : this.model.y,
																 name : this.model.text
															 });
				_.editPart = this;
				return _
			},
			canCreateIncome : function() {
				if(this.getTargetConnections().length == 0){
					return true;
				}else{
					Interface.Event.trigger(Interface.EventMode.Alert,"判断节点只能有一个入边。")
					return false
				}
			},
			canCreateOutgo : function() {
				if (this.getSourceConnections().length < 2)
					return true;
				else {
					Interface.Event.trigger(Interface.EventMode.Alert,"判断节点最多有两个出边。")
					return false
				}
			},
			canResize : function() {
				return false
			}
		});
		//新增的节点入口：会签
		Interface.simple.editpart.CountersignEditPart  = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var _ = new Interface.simple.figure.CountersignFigure({
																	x : this.model.x,
																	y : this.model.y,
																	name : this.model.text
																});
				_.editPart = this;
				return _
			},
			canResize : function() {
				return true
			}
		});
		//新增的节点入口：子流程
		Interface.simple.editpart.SubprocessEditPart  = Interface.extend(Interface.gef.editparts.NodeEditPart, {
			createFigure : function() {
				var _ = new Interface.simple.figure.SubprocessFigure({
																   x : this.model.x,
																   y : this.model.y,
																   name : this.model.text
															   });
				_.editPart = this;
				return _
			},
			canResize : function() {
				return true
			}
		});
		//新增的节点入口：节点连线
		Interface.simple.editpart.TransitionEditPart = Interface.extend(Interface.gef.editparts.ConnectionEditPart, {
			createFigure : function() {
				var $ = this.getModel(),
					_ = new Interface.simple.figure.TransitionFigure(this.getSource().getFigure(), this.getTarget().getFigure());
				_.innerPoints = $.innerPoints;
				_.name = $.text;
				_.textX = $.textX;
				_.textY = $.textY;
				_.editPart = this;
				return _
			}
		});


		Interface.ns("Interface.simple.model");
		Interface.simple.model.ProcessModel = Interface.extend(Interface.model.NodeModel, {
			type : "process"
		});
		//新增的节点模型：开始
		Interface.simple.model.StartModel = Interface.extend(Interface.model.NodeModel, {
			type : "start"
		});
		//新增的节点模型：结束
		Interface.simple.model.EndModel = Interface.extend(Interface.model.NodeModel, {
			type : "end"
		});
		//新增的节点模型：任务
		Interface.simple.model.TaskModel = Interface.extend(Interface.model.NodeModel, {
			type : "task"
		});
		//新增的节点模型：状态
		Interface.simple.model.StateModel = Interface.extend(Interface.model.NodeModel, {
			type : "state"
		});
		//新增的节点模型：分支
		Interface.simple.model.ForkModel = Interface.extend(Interface.model.NodeModel, {
			type : "fork"
		});
		//新增的节点模型：合并
		Interface.simple.model.JoinModel = Interface.extend(Interface.model.NodeModel, {
			type : "join"
		});
		//新增的节点模型：判断
		Interface.simple.model.DecisionModel = Interface.extend(Interface.model.NodeModel, {
			type : "decision"
		});
		//新增的节点模型：会签
		Interface.simple.model.CountersignModel = Interface.extend(Interface.model.NodeModel, {
			type : "sign"
		});
		//新增的节点模型：子流程
		Interface.simple.model.SubprocessModel = Interface.extend(Interface.model.NodeModel, {
			type : "sub"
		});
		//新增的节点模型：节点连线
		Interface.simple.model.TransitionModel = Interface.extend(Interface.model.ConnectionModel, {
			type : "transition"
		});
		//新增的节点模型：中止
		Interface.simple.model.EndCancelModel = Interface.extend(Interface.model.NodeModel, {
			type : "endCancel"
		});
	},
	//初始化图型接口基类
	initFigure : function(Interface) {
		Interface.ns("Interface.figure");
		Interface.figure.Figure = Interface.extend(Object, {
			constructor : function($) {
				this.children = [];
				$ = $ ? $ : {};
				Interface.apply(this, $)
			},
			setParent : function($) {
				this.parent = $
			},
			getParent : function() {
				return this.parent
			},
			getParentEl : function() {
				return this.parent.el
			},
			getChildren : function() {
				return this.children
			},
			addChild : function($) {
				this.children.push($);
				$.setParent(this)
			},
			removeChild : function($) {
				$.remove()
			},
			render : function() {
				if (!this.el)
					if (Interface.isVml) {
						this.renderVml();
						this.onRenderVml()
					} else {
						this.renderSvg();
						this.onRenderSvg()
					}
				for (var $ = 0; $ < this.children.length; $++)
					this.children[$].render()
			},
			renderSvg : Interface.emptyFn,
			renderVml : Interface.emptyFn,
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("fill", "white");
				this.el.setAttribute("stroke", "black");
				this.el.setAttribute("stroke-width", "1");
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			getId : function() {
				return this.el.getAttribute("id")
			},
			remove : function() {
				this.parent.getChildren().remove(this);
				this.getParentEl().removeChild(this.el)
			},
			show : function() {
				this.el.style.display = ""
			},
			hide : function() {
				this.el.style.display = "none"
			},
			moveTo : Interface.emptyFn,
			update : Interface.emptyFn
		});
		Interface.figure.GroupFigure = Interface.extend(Interface.figure.Figure, {
			renderVml : function() {
				var $ = document.createElement("div");
				$.id = this.id;
				this.el = $;
				this.getParentEl().appendChild($)
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("id", this.id);
				this.el = $;
				this.getParentEl().appendChild($)
			},
			onRenderVml : function() {
			},
			onRenderSvg : function() {
			}
		});
		Interface.figure.LineFigure = Interface.extend(Interface.figure.Figure, {
			renderVml : function() {
				var $ = document.createElement("v:line");
				$.from = this.x1 + "," + this.y1;
				$.to = this.x2 + "," + this.y2;
				this.el = $
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "line");
				$.setAttribute("x1", this.x1 + "px");
				$.setAttribute("y1", this.y1 + "px");
				$.setAttribute("x2", this.x2 + "px");
				$.setAttribute("y2", this.y2 + "px");
				this.el = $
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.el.setAttribute("strokeweight", 2);
				this.el.setAttribute("strokecolor", "blue");
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("fill", "white");
				this.el.setAttribute("stroke", "blue");
				this.el.setAttribute("stroke-width", "2");
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			update : function(B, $, A, _) {
				this.x1 = B;
				this.y1 = $;
				this.x2 = A;
				this.y2 = _;
				if (Interface.isVml)
					this.updateVml();
				else
					this.updateSvg()
			},
			updateVml : function() {
				this.el.from = this.x1 + "," + this.y1;
				this.el.to = this.x2 + "," + this.y2
			},
			updateSvg : function() {
				this.el.setAttribute("x1", this.x1 + "px");
				this.el.setAttribute("y1", this.y1 + "px");
				this.el.setAttribute("x2", this.x2 + "px");
				this.el.setAttribute("y2", this.y2 + "px")
			}
		});
		Interface.figure.PolylineFigure = Interface.extend(Interface.figure.Figure, {
			getPoint : function(_, A) {
				var $ = "";
				for (var C = 0; C < this.points.length; C++) {
					var B = this.points[C];
					$ += (B[0] + _) + "," + (B[1] + A) + " "
				}
				return $
			},
			renderVml : function() {
				var $ = document.createElement("v:polyline");
				$.setAttribute("points", this.getPoint(0, 0));
				this.el = $
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "polyline");
				$.setAttribute("points", this.getPoint(0, 0));
				this.el = $
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.el.setAttribute("strokeweight", 2);
				this.el.setAttribute("strokecolor", "blue");
				Interface.model.root.appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("fill", "none");
				this.el.setAttribute("stroke", "blue");
				this.el.setAttribute("stroke-width", "2");
				this.el.setAttribute("cursor", "pointer");
				Interface.model.root.appendChild(this.el)
			},
			onSelectVml : function() {
				this.el.setAttribute("strokeweight", "4");
				this.el.setAttribute("strokecolor", "green")
			},
			onSelectSvg : function() {
				this.el.setAttribute("stroke-width", "4");
				this.el.setAttribute("stroke", "green")
			},
			onDeselectVml : function() {
				this.el.setAttribute("strokeweight", "2");
				this.el.setAttribute("strokecolor", "blue")
			},
			onDeselectSvg : function() {
				this.el.setAttribute("stroke-width", "2");
				this.el.setAttribute("stroke", "blue")
			}
		});
		Interface.figure.PolygonFigure = Interface.extend(Interface.figure.Figure, {
			getPoint : function(_, A) {
				var $ = "";
				for (var C = 0; C < this.points.length; C++) {
					var B = this.points[C];
					$ += (B[0] + _) + "," + (B[1] + A) + " "
				}
				return $
			},
			renderVml : function() {
				var $ = document.createElement("v:polyline");
				$.setAttribute("points", this.getPoint(0, 0));
				this.el = $
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "polygon");
				$.setAttribute("points", this.getPoint(0, 0));
				this.el = $
			},
			move : function($, _) {
				this.moveTo(this.x + $, this.y + _)
			},
			moveTo : function(_, $) {
				this.x = _;
				this.y = $;
				if (Interface.isVml)
					this.moveToVml();
				else
					this.moveToSvg()
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function(_, $) {
				this.el.setAttribute("x", this.x);
				this.el.setAttribute("y", this.y)
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.updateVml();
				else
					this.updateSvg()
			},
			updateVml : function() {
				this.moveToVml();
				this.el.style.width = this.w + "px";
				this.el.style.height = this.h + "px"
			},
			updateSvg : function() {
				this.moveToSvg();
				this.el.setAttribute("width", this.w);
				this.el.setAttribute("height", this.h)
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				this.update(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			}
		});
		Interface.figure.RectFigure = Interface.extend(Interface.figure.Figure, {
			renderVml : function() {
				var $ = document.createElement("v:rect");
				$.style.left = this.x + "px";
				$.style.top = this.y + "px";
				$.style.width = this.w + "px";
				$.style.height = this.h + "px";
				this.el = $
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "rect");
				$.setAttribute("x", this.x + "px");
				$.setAttribute("y", this.y + "px");
				$.setAttribute("width", this.w + "px");
				$.setAttribute("height", this.h + "px");
				this.el = $
			},
			move : function($, _) {
				this.moveTo(this.x + $, this.y + _)
			},
			moveTo : function(_, $) {
				this.x = _;
				this.y = $;
				if (Interface.isVml)
					this.moveToVml();
				else
					this.moveToSvg()
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function(_, $) {
				this.el.setAttribute("x", this.x);
				this.el.setAttribute("y", this.y)
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.updateVml();
				else
					this.updateSvg()
			},
			updateVml : function() {
				this.moveToVml();
				this.el.style.width = this.w + "px";
				this.el.style.height = this.h + "px"
			},
			updateSvg : function() {
				this.moveToSvg();
				this.el.setAttribute("width", this.w);
				this.el.setAttribute("height", this.h)
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				this.update(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			}
		});
		Interface.figure.CircleFigure = Interface.extend(Interface.figure.Figure,{
			renderVml : function() {
				var $ = document.createElement("v:circle");
				$.style.left = this.x + "px";
				$.style.top = this.y + "px";
				$.style.width = this.w + "px";
				$.style.height = this.h + "px";
				this.el = $
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "circle");
				$.setAttribute("cx", this.x + "px");
				$.setAttribute("cy", this.y + "px");
				$.setAttribute("r", this.r + "px");
				this.el = $
			},
			move : function($, _) {
				this.moveTo(this.x + $, this.y + _)
			},
			moveTo : function(_, $) {
				this.x = _;
				this.y = $;
				if (Interface.isVml)
					this.moveToVml();
				else
					this.moveToSvg()
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function() {
				this.el.setAttribute("cx", this.x);
				this.el.setAttribute("cy", this.y)
			},
			update : function(B, A, $) {
				this.x = B;
				this.y = A;
				this.r = $;
				if (Interface.isVml)
					this.updateVml();
				else
					this.updateSvg()
			},
			updateVml : function() {
				this.moveToVml();
				this.el.style.width = this.w + "px";
				this.el.style.height = this.h + "px"
			},
			updateSvg : function() {
				this.moveToSvg();
				this.el.setAttribute("r", this.r);
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			}
		});
		Interface.figure.RoundRectFigure = Interface.extend(Interface.figure.RectFigure, {
			renderVml : function() {
				Interface.figure.RoundRectFigure.superclass.renderVml.call(this);
				this.el.arcsize = 0.1
			},
			renderSvg : function() {
				Interface.figure.RoundRectFigure.superclass.renderSvg.call(this);
				this.el.setAttribute("rx", 10);
				this.el.setAttribute("ry", 10)
			}
		});
		Interface.figure.ImaInterfaceigure = Interface.extend(Interface.figure.RectFigure, {
			renderVml : function() {
				var $ = document.createElement("img");
				$.style.left = this.x + "px";
				$.style.top = this.y + "px";
				$.setAttribute("src", this.url);
				this.el = $
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "image");
				$.setAttribute("x", this.x + "px");
				$.setAttribute("y", this.y + "px");
				$.setAttribute("width", "48px");
				$.setAttribute("height", "48px");
				$.setAttributeNS(Interface.linkns, "xlink:href", this.url);
				this.el = $
			},
			update : function(B, A, $, _) {
				this.moveTo(B, A)
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			}
		});
		Interface.figure.RootFigure = Interface.extend(Interface.figure.Figure, {
			render : function() {
				this.getParentEl().onselectstart = function() {
					return false
				};
				Interface.figure.RootFigure.superclass.render.call(this)
			},
			renderVml : function() {
				var $ = document.createElement("div");
				this.getParentEl().appendChild($);
				this.el = $
			},
			renderSvg : function() {
				var E = this.getParentEl(), _ = E.ownerDocument.createElementNS(Interface.svgns, "svg");
				_.setAttribute("id", Interface.id());
				_.setAttribute("width", E.style.width.replace(/px/, ""));
				_.setAttribute("height", E.style.height.replace(/px/, ""));
				_.style.fontFamily = "Verdana";
				_.style.fontSize = "12px";
				E.appendChild(_);
				var $ = _.ownerDocument.createElementNS(Interface.svgns, "defs");
				_.appendChild($);
				var B = _.ownerDocument.createElementNS(Interface.svgns, "marker");
				B.setAttribute("id", Interface.parentid + "_markerArrow");
				B.setAttribute("markerUnits", "userSpaceOnUse");
				B.setAttribute("markerWidth", 8);
				B.setAttribute("markerHeight", 8);
				B.setAttribute("refX", 8);
				B.setAttribute("refY", 4);
				B.setAttribute("orient", "auto");
				var A = _.ownerDocument.createElementNS(Interface.svgns, "path");
				A.setAttribute("d", "M 0 0 L 8 4 L 0 8 z");
				A.setAttribute("stroke", "#909090");
				A.setAttribute("fill", "#909090");
				B.appendChild(A);
				$.appendChild(B);
				var D = _.ownerDocument.createElementNS(Interface.svgns, "marker");
				D.setAttribute("id", Interface.parentid + "_markerDiamond");
				D.setAttribute("markerUnits", "userSpaceOnUse");
				D.setAttribute("markerWidth", 16);
				D.setAttribute("markerHeight", 8);
				D.setAttribute("refX", 0);
				D.setAttribute("refY", 4);
				D.setAttribute("orient", "auto");
				var C = _.ownerDocument.createElementNS(Interface.svgns, "path");
				C.setAttribute("d", "M 0 4 L 8 8 L 16 4 L 8 0 z");
				C.setAttribute("stroke", "#909090");
				C.setAttribute("fill", "#FFFFFF");
				D.appendChild(C);
				$.appendChild(D);
				this.el = _
			},
			onRenderVml : function() {
			},
			onRenderSvg : function() {
			}
		});
		Interface.figure.NoFigure = Interface.extend(Interface.figure.Figure, {
			render : Interface.emptyFn,
			update : Interface.emptyFn
		});
		Interface.figure.NodeFigure = Interface.extend(Interface.figure.RoundRectFigure, {
			constructor : function($) {
				this.outputs = [];
				this.incomes = [];
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.w = 90;
				this.h = 50
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;
				var B = document.createElement("v:roundrect");
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";
				B.setAttribute("arcsize", 0.2);
				B.setAttribute("fillcolor", Interface.CANVAS_FILL);
				B.setAttribute("strokecolor", Interface.CANVAS_STROKE);
				B.setAttribute("strokeweight", "1");
				B.style.verticalAlign = "middle";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				B.appendChild(this.shadow);
				$.appendChild(B);
				this.rectEl = B;
				var _ = this.getTextPosition(this.w, this.h), A = document.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				var roundRectFilter = Interface.parentid + "_roundRectFilter_" + Interface.seed;
				//加上阴影
				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", roundRectFilter);
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 8);
				fe2.setAttribute("dy", 8);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				this.shadow = document.createElementNS(Interface.svgns, "rect");
				this.shadow.setAttribute("width", (this.w - 10) + "px");
				this.shadow.setAttribute("height", (this.h - 10) + "px");
				this.shadow.setAttribute("rx", 5);
				this.shadow.setAttribute("ry", 5);
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#"+ roundRectFilter +")");

				$.appendChild(this.def);
				$.appendChild(this.shadow);
				//-------------------------------------------------------------------------
				var B = document.createElementNS(Interface.svgns, "rect");
				B.setAttribute("x", 5);
				B.setAttribute("y", 5);
				B.setAttribute("width", (this.w - 10) + "px");
				B.setAttribute("height", (this.h - 10) + "px");
				B.setAttribute("rx", 6);
				B.setAttribute("ry", 6);
				B.setAttribute("fill", Interface.CANVAS_FILL);
				B.setAttribute("stroke", Interface.CANVAS_STROKE);
				B.setAttribute("stroke-width", "2");
				$.appendChild(B);
				this.rectEl = B;
				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElementNS(Interface.svgns, "text");

				A.setAttribute("x", _.x);
				A.setAttribute("y", _.y);
				A.setAttribute("text-anchor", "middle");
				A.textContent = this.name;
				$.appendChild(A);

				this.textEl = A
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			getTextPosition : function($, _) {
				if (Interface.isVml)
					return this.getTextPositionVml($, _);
				else
					return this.getTextPositionSvg($, _)
			},
			getTextPositionVml : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			getTextPositionSvg : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2 + _.h / 4;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			hideText : function() {
				this.textEl.style.display = "none"
			},
			updateAndShowText : function($) {
				this.name = $;
				if (Interface.isVml)
					this.textEl.innerHTML = $;
				else
					this.textEl.textContent = $;
				this.textEl.style.display = ""
			},
			cancelEditText : function() {
				this.textEl.style.display = ""
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				this.rectEl.setAttribute("width", ($ - 10) + "px");
				this.rectEl.setAttribute("height", (A - 10) + "px");
				var _ = this.getTextPosition($, A);
				this.textEl.setAttribute("x", _.x);
				this.textEl.setAttribute("y", _.y)
				//阴影也要跟着resize。Jacky-----------------------------------------
				this.shadow.setAttribute("width", (this.w - 10) + "px");
				this.shadow.setAttribute("height", (this.h - 10) + "px");
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.LogicNodeFigure = Interface.extend(Interface.figure.RoundRectFigure, {
			constructor : function($) {
				this.outputs = [];
				this.incomes = [];
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.w = 100;
				this.h = 60
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;

				var B = document.createElement("v:image");
				B.setAttribute("src", this.url);
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				var roundRectFilter = Interface.parentid + "_roundRectFilter_" + Interface.seed;
				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", roundRectFilter);
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 8);
				fe2.setAttribute("dy", 8);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				this.shadow = document.createElementNS(Interface.svgns, "rect");
				this.shadow.setAttribute("width", (this.w - 10) + "px");
				this.shadow.setAttribute("height", (this.h - 10) + "px");
				this.shadow.setAttribute("rx", 5);
				this.shadow.setAttribute("ry", 5);
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#"+ roundRectFilter + ")");
				$.appendChild(this.def);

				var B = document.createElementNS(Interface.svgns, "image");
				B.setAttribute("x", 5);
				B.setAttribute("y", 5);
				B.setAttribute("width", (this.w - 10) + "px");
				B.setAttribute("height", (this.h - 10) + "px");
				B.setAttributeNS(Interface.linkns, "xlink:href", this.url);
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElementNS(Interface.svgns, "text");
				A.setAttribute("x", _.x);
				A.setAttribute("y", _.y);
				A.setAttribute("text-anchor", "middle");
				A.textContent = this.name;
				$.appendChild(A);

				this.textEl = A
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			getTextPosition : function($, _) {
				if (Interface.isVml)
					return this.getTextPositionVml($, _);
				else
					return this.getTextPositionSvg($, _)
			},
			getTextPositionVml : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			getTextPositionSvg : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2 + _.h / 4;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			hideText : function() {
				this.textEl.style.display = "none"
			},
			updateAndShowText : function($) {
				this.name = $;
				if (Interface.isVml)
					this.textEl.innerHTML = $;
				else
					this.textEl.textContent = $;
				this.textEl.style.display = ""
			},
			cancelEditText : function() {
				this.textEl.style.display = ""
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				this.rectEl.setAttribute("width", ($ - 10) + "px");
				this.rectEl.setAttribute("height", (A - 10) + "px");
				var _ = this.getTextPosition($, A);
				this.textEl.setAttribute("x", _.x);
				this.textEl.setAttribute("y", _.y)
				//阴影也要跟着resize。Jacky-----------------------------------------
				this.shadow.setAttribute("width", (this.w - 10) + "px");
				this.shadow.setAttribute("height", (this.h - 10) + "px");
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.SignNodeFigure = Interface.extend(Interface.figure.PolygonFigure, {
			constructor : function($) {
				this.points = [];
				this.outputs = [];
				this.incomes = [];
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.w = 100;
				this.h = 60
				this.createPoints(this.w,this.h,5)
			},
			createPoints : function(w,h,z){
				this.points = [];
				this.points.push([w/3,z]);
				this.points.push([z,h/2]);
				this.points.push([w/3,h-z]);
				this.points.push([w/3*2,h-z]);
				this.points.push([w-z,h/2]);
				this.points.push([w/3*2,z]);
			},

			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;

				var B = document.createElement("v:image");
				B.setAttribute("src", this.url);
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", "polygonFilter");
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 3);
				fe2.setAttribute("dy", 3);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				this.shadow = document.createElementNS(Interface.svgns, "polygon");
				this.shadow.setAttribute("points", this.getPoint(0, 0));
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#polygonFilter)");
				$.appendChild(this.def);
				$.appendChild(this.shadow);

				var B = document.createElementNS(Interface.svgns, "polygon");
				B.setAttribute("points", this.getPoint(0, 0));
				B.setAttribute("fill", Interface.CANVAS_FILL);
				B.setAttribute("stroke", Interface.CANVAS_STROKE);
				B.setAttribute("stroke-width", "2");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElementNS(Interface.svgns, "text");
				A.setAttribute("x", _.x);
				A.setAttribute("y", _.y);
				A.setAttribute("text-anchor", "middle");
				A.textContent = this.name;
				$.appendChild(A);

				this.textEl = A
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			getTextPosition : function($, _) {
				if (Interface.isVml)
					return this.getTextPositionVml($, _);
				else
					return this.getTextPositionSvg($, _)
			},
			getTextPositionVml : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			getTextPositionSvg : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2 + _.h / 4;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			hideText : function() {
				this.textEl.style.display = "none"
			},
			updateAndShowText : function($) {
				this.name = $;
				if (Interface.isVml)
					this.textEl.innerHTML = $;
				else
					this.textEl.textContent = $;
				this.textEl.style.display = ""
			},
			cancelEditText : function() {
				this.textEl.style.display = ""
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				this.createPoints($,A,5)
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				this.rectEl.setAttribute("points", this.getPoint(0, 0));
				var _ = this.getTextPosition($, A);
				this.textEl.setAttribute("x", _.x);
				this.textEl.setAttribute("y", _.y)
				//阴影也要跟着resize。Jacky-----------------------------------------
				this.shadow.setAttribute("points", this.getPoint(0, 0));
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.SubprocessNodeFigure = Interface.extend(Interface.figure.RoundRectFigure, {
			constructor : function($) {
				this.outputs = [];
				this.incomes = [];
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.w = 100;
				this.h = 60
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;

				var B = document.createElement("v:roundrect");
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";
				B.setAttribute("arcsize", 0.5);
				B.setAttribute("fillcolor", Interface.CANVAS_FILL);
				B.setAttribute("strokecolor", Interface.CANVAS_STROKE);
				B.setAttribute("strokeweight", "1");
				B.style.verticalAlign = "middle";

				//加上阴影
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				var roundRectFilter = Interface.parentid + "_roundRectFilter_" + Interface.seed;
				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", roundRectFilter);
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 8);
				fe2.setAttribute("dy", 8);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				this.shadow = document.createElementNS(Interface.svgns, "rect");
				this.shadow.setAttribute("width", (this.w - 10) + "px");
				this.shadow.setAttribute("height", (this.h - 10) + "px");
				this.shadow.setAttribute("rx", this.h * 0.5);
				this.shadow.setAttribute("ry", this.h * 0.5);
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#"+ roundRectFilter + ")");
				$.appendChild(this.def);
				$.appendChild(this.shadow);

				var B = document.createElementNS(Interface.svgns, "rect");
				B.setAttribute("x", 5);
				B.setAttribute("y", 5);
				B.setAttribute("width", (this.w - 10) + "px");
				B.setAttribute("height", (this.h - 10) + "px");
				B.setAttribute("rx", this.h * 0.5);
				B.setAttribute("ry", this.h * 0.5);
				B.setAttribute("fill", Interface.CANVAS_FILL);
				B.setAttribute("stroke", Interface.CANVAS_STROKE);
				B.setAttribute("stroke-width", "2");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElementNS(Interface.svgns, "text");
				A.setAttribute("x", _.x);
				A.setAttribute("y", _.y);
				A.setAttribute("text-anchor", "middle");
				A.textContent = this.name;
				$.appendChild(A);

				this.textEl = A
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			getTextPosition : function($, _) {
				if (Interface.isVml)
					return this.getTextPositionVml($, _);
				else
					return this.getTextPositionSvg($, _)
			},
			getTextPositionVml : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			getTextPositionSvg : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2 + _.h / 4;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			hideText : function() {
				this.textEl.style.display = "none"
			},
			updateAndShowText : function($) {
				this.name = $;
				if (Interface.isVml)
					this.textEl.innerHTML = $;
				else
					this.textEl.textContent = $;
				this.textEl.style.display = ""
			},
			cancelEditText : function() {
				this.textEl.style.display = ""
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				this.rectEl.setAttribute("width", ($ - 10) + "px");
				this.rectEl.setAttribute("height", (A - 10) + "px");
				this.rectEl.setAttribute("rx", this.h * 0.5);
				this.rectEl.setAttribute("ry", this.h * 0.5);
				var _ = this.getTextPosition($, A);
				this.textEl.setAttribute("x", _.x);
				this.textEl.setAttribute("y", _.y)
				//阴影也要跟着resize。Jacky-----------------------------------------
				this.shadow.setAttribute("width", (this.w - 10) + "px");
				this.shadow.setAttribute("height", (this.h - 10) + "px");
				this.shadow.setAttribute("rx", this.h * 0.5);
				this.shadow.setAttribute("ry", this.h * 0.5);
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.StartNodeFigure = Interface.extend(Interface.figure.CircleFigure,{
			constructor : function($) {
				this.points = [];
				this.outputs = [];
				this.incomes = [];
				this.w = 50;
				this.h = 50;
				this.r = this.w / 2;
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.createPoints(this.w,this.h)
			},
			createPoints : function(w,h){
				this.points = [];
				this.points.push([w/5*2+2,h/3]);
				this.points.push([w/5*2+2,h/3*2]);
				this.points.push([w/5*3+2,h/2]);
			},
			getPoint : function(_, A) {
				var $ = "";
				for (var C = 0; C < this.points.length; C++) {
					var B = this.points[C];
					$ += (B[0] + _) + "," + (B[1] + A) + " "
				}
				return $
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;

				var B = document.createElement("v:image");
				B.setAttribute("src", this.url);
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				$.appendChild(B);
				this.rectEl = B;
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", "circleFilter");
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 3);
				fe2.setAttribute("dy", 3);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				this.shadow = document.createElementNS(Interface.svgns, "circle");
				this.shadow.setAttribute("cx", this.r + "px");
				this.shadow.setAttribute("cy", this.r + "px");
				this.shadow.setAttribute("r", (this.r - 5) + "px");
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#circleFilter)");
				$.appendChild(this.def);
				$.appendChild(this.shadow);

				var B = document.createElementNS(Interface.svgns, "circle");
				B.setAttribute("cx", this.r + "px");
				B.setAttribute("cy", this.r + "px");
				B.setAttribute("r", (this.r - 5) + "px");
				B.setAttribute("fill", Interface.CANVAS_FILL);
				B.setAttribute("stroke", Interface.CANVAS_STROKE);
				B.setAttribute("stroke-width", "2");
				$.appendChild(B);
				this.rectEl = B;

				var C = document.createElementNS(Interface.svgns, "polygon");
				C.setAttribute("points", this.getPoint(0, 0));
				C.setAttribute("fill", "#408dbe");
				C.setAttribute("stroke", "#408dbe");
				C.setAttribute("stroke-width", "2");
				$.appendChild(C);

			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				if($ > _){
					this.w = $;
					this.h = $;
				}else{
					this.w = _;
					this.h = _;
				}
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				var R = $ / 2;
				if($ < A){
					R = A / 2;
				}
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				this.rectEl.setAttribute("cx", R);
				this.rectEl.setAttribute("cy", R);
				this.rectEl.setAttribute("r", R - 5);
				//阴影也要跟着resize。Jacky----------------------------------------
				this.shadow.setAttribute("cx", R);
				this.shadow.setAttribute("cy", R);
				this.shadow.setAttribute("r", R - 5);
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.EndNodeFigure = Interface.extend(Interface.figure.CircleFigure,{
			constructor : function($) {
				this.outputs = [];
				this.incomes = [];
				this.w = 50;
				this.h = 50;
				this.r = this.w / 2;
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;

				var B = document.createElement("v:image");
				B.setAttribute("src", this.url);
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", "circleFilter");
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 3);
				fe2.setAttribute("dy", 3);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				this.shadow = document.createElementNS(Interface.svgns, "circle");
				this.shadow.setAttribute("cx", this.r + "px");
				this.shadow.setAttribute("cy", this.r + "px");
				this.shadow.setAttribute("r", (this.r - 5) + "px");
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#circleFilter)");
				$.appendChild(this.def);
				$.appendChild(this.shadow);

				var B = document.createElementNS(Interface.svgns, "circle");
				B.setAttribute("cx", this.r + "px");
				B.setAttribute("cy", this.r + "px");
				B.setAttribute("r", (this.r - 5) + "px");
				B.setAttribute("fill", Interface.CANVAS_FILL);
				B.setAttribute("stroke", Interface.CANVAS_STROKE);
				B.setAttribute("stroke-width", "2");
				$.appendChild(B);
				this.rectEl = B;

				var C = document.createElementNS(Interface.svgns, "rect");
				C.setAttribute("x", (this.w / 4 + this.w / 8) + "px");
				C.setAttribute("y", (this.h / 4 + this.h / 8) + "px");
				C.setAttribute("width", this.w / 4 + "px");
				C.setAttribute("height", this.h / 4 + "px");
				C.setAttribute("fill", Interface.CANVAS_STROKE);
				C.setAttribute("stroke", Interface.CANVAS_STROKE);
				C.setAttribute("stroke-width", "2");
				$.appendChild(C);
				this.centerEl = C;

			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				if($ > _){
					this.w = $;
					this.h = $;
				}else{
					this.w = _;
					this.h = _;
				}
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				var R = $ / 2;
				if($ < A){
					R = A / 2;
				}

				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				this.rectEl.setAttribute("cx", R);
				this.rectEl.setAttribute("cy", R);
				this.rectEl.setAttribute("r", R - 5);

				this.centerEl.setAttribute("x", ($ / 4 + $ / 8) + "px");
				this.centerEl.setAttribute("y", (A / 4 + A / 8) + "px");

				//阴影也要跟着resize。Jacky----------------------------------------
				this.shadow.setAttribute("cx", R);
				this.shadow.setAttribute("cy", R);
				this.shadow.setAttribute("r", R - 5);
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.CancelNodeFigure = Interface.extend(Interface.figure.CircleFigure,{
			constructor : function($) {
				this.points = [];
				this.outputs = [];
				this.incomes = [];
				this.w = 50;
				this.h = 50;
				this.r = this.w / 2;
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.createPoints(this.w,this.h)
			},
			createPoints : function(w,h){
				this.points = [];
				var nw = w,
					nh = h;
				this.points.push([nw/3+2,nh/3-1]);
				this.points.push([nw/3-1,nh/3+2]);
				this.points.push([nw/2-1,nh/2+1]);
				this.points.push([nw/3-1,nh/3*2]);
				this.points.push([nw/3+2,nh/3*2+2]);
				this.points.push([nw/2+1,nh/2+4]);
				this.points.push([nw/3*2,nh/3*2+2]);
				this.points.push([nw/3*2+2,nh/3*2-1]);
				this.points.push([nw/2+4,nh/2+1]);
				this.points.push([nw/3*2+3,nh/3+2]);
				this.points.push([nw/3*2,nh/3]);
				this.points.push([nw/2+1,nh/2-2]);
			},
			getPoint : function(_, A) {
				var $ = "";
				for (var C = 0; C < this.points.length; C++) {
					var B = this.points[C];
					$ += (B[0] + _) + "," + (B[1] + A) + " "
				}
				return $
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;

				var B = document.createElement("v:image");
				B.setAttribute("src", this.url);
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", "circleFilter");
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 3);
				fe2.setAttribute("dy", 3);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				this.shadow = document.createElementNS(Interface.svgns, "circle");
				this.shadow.setAttribute("cx", this.r + "px");
				this.shadow.setAttribute("cy", this.r + "px");
				this.shadow.setAttribute("r", (this.r - 5) + "px");
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#circleFilter)");
				$.appendChild(this.def);
				$.appendChild(this.shadow);

				var B = document.createElementNS(Interface.svgns, "circle");
				B.setAttribute("cx", this.r + "px");
				B.setAttribute("cy", this.r + "px");
				B.setAttribute("r", (this.r - 5) + "px");
				B.setAttribute("fill", "#f8d5d3");
				B.setAttribute("stroke", "#e94735");
				B.setAttribute("stroke-width", "2");
				$.appendChild(B);
				this.rectEl = B;

				var C = document.createElementNS(Interface.svgns, "polygon");
				C.setAttribute("points", this.getPoint(0, 0));
				C.setAttribute("fill", "#ea4f3f");
				C.setAttribute("stroke", "#ea4f3f");
				$.appendChild(C);
				this.centerEl = C;

			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				if($ > _){
					this.w = $;
					this.h = $;
				}else{
					this.w = _;
					this.h = _;
				}
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				var R = $ / 2;
				if($ < A){
					R = A / 2;
				}
				this.createPoints($,A)
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				this.rectEl.setAttribute("cx", R);
				this.rectEl.setAttribute("cy", R);
				this.rectEl.setAttribute("r", R - 5);

				this.centerEl.setAttribute("points", this.getPoint(0, 0));
				//阴影也要跟着resize。Jacky----------------------------------------
				this.shadow.setAttribute("cx", R);
				this.shadow.setAttribute("cy", R);
				this.shadow.setAttribute("r", R - 5);
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.DecisionNodeFigure = Interface.extend(Interface.figure.PolygonFigure, {
			constructor : function($) {
				this.rotate = 0;
				this.points = [];
				this.outputs = [];
				this.incomes = [];
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.w = 100;
				this.h = 60
				this.createPoints(this.w, this.h, 5)
			},
			setRotate : function(rotate){
				this.editPart.model.rotate = rotate;
				if (Interface.isVml)
					this.resizeVml(this.x, this.y, this.w, this.h);
				else
					this.resizeSvg(this.x, this.y, this.w, this.h)
			},
			createPoints : function(w,h,z){
				this.points = [];
				if(typeof this.editPart == "undefined"){
					this.rotate = 0;
				}else{
					this.rotate = this.editPart.model.rotate;
				}
				var nw = w, nh = h;
				if(this.rotate == 0)
				{
					if(nw < nh){
						this.w = nh;
						this.h = nw;
						w = nh;
						h = nw;
					}
					this.points.push([z, z]);
					this.points.push([w / 2, h - z]);
					this.points.push([w - z, z]);
				}else if(this.rotate == 1){
					if(nw > nh){
						this.w = nh;
						this.h = nw;
						w = nh;
						h = nw;
					}
					this.points.push([z, z]);
					this.points.push([z, h - z]);
					this.points.push([w - z, h / 2]);
				}else if(this.rotate == 2){
					if(nw < nh){
						this.w = nh;
						this.h = nw;
						w = nh;
						h = nw;
					}
					this.points.push([w / 2, z]);
					this.points.push([z, h - z]);
					this.points.push([w - z, h - z]);
				}else if(this.rotate == 3){
					if(nw > nh){
						this.w = nh;
						this.h = nw;
						w = nh;
						h = nw;
					}
					this.points.push([z, h / 2]);
					this.points.push([w - z, h - z]);
					this.points.push([w - z, z]);
				}
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;

				var B = document.createElement("v:image");
				B.setAttribute("src", this.url);
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", "polygonFilter");
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 3);
				fe2.setAttribute("dy", 3);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				this.shadow = document.createElementNS(Interface.svgns, "polygon");
				this.shadow.setAttribute("points", this.getPoint(0, 0));
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#polygonFilter)");
				$.appendChild(this.def);
				$.appendChild(this.shadow);

				var B = document.createElementNS(Interface.svgns, "polygon");
				B.setAttribute("points", this.getPoint(0, 0));
				B.setAttribute("fill", Interface.CANVAS_FILL);
				B.setAttribute("stroke", Interface.CANVAS_STROKE);
				B.setAttribute("stroke-width", "2");
				$.appendChild(B);
				this.rectEl = B;

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElementNS(Interface.svgns, "text");
				A.setAttribute("x", _.x);
				A.setAttribute("y", _.y);
				A.setAttribute("text-anchor", "middle");
				A.textContent = "判断";
				$.appendChild(A);

				this.textEl = A
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			getTextPosition : function($, _) {
				if (Interface.isVml)
					return this.getTextPositionVml($, _);
				else
					return this.getTextPositionSvg($, _)
			},
			getTextPositionVml : function($, B) {
				var _ = Interface.getTextSize("判断"), C = $ / 2, A = B / 2;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			getTextPositionSvg : function($, B) {
				var _ = Interface.getTextSize("判断"), C = $ / 2, A = B / 2 + _.h / 4;
				if(this.rotate == 0){
					A = A / 3 * 2;
				}else if(this.rotate == 1){
					C = C / 3 * 2;
				}else if(this.rotate == 2){
					A = A + A / 3;
				}else if(this.rotate == 3){
					C = C + C / 4;
				}
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			hideText : function() {
				this.textEl.style.display = "none"
			},
			// 去掉此函数将不能修改文本
			// updateAndShowText : function($) {
			// 	this.name = $;
			// 	if (Interface.isVml)
			// 		this.textEl.innerHTML = $;
			// 	else
			// 		this.textEl.textContent = $;
			// 	this.textEl.style.display = ""
			// },
			// cancelEditText : function() {
			// 	this.textEl.style.display = ""
			// },
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				this.createPoints($,A,5)
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				this.rectEl.setAttribute("points", this.getPoint(0, 0));
				var _ = this.getTextPosition(this.w, this.h);
				this.textEl.setAttribute("x", _.x);
				this.textEl.setAttribute("y", _.y)
				this.shadow.setAttribute("points", this.getPoint(0, 0));
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.ForkNodeFigure = Interface.extend(Interface.figure.RoundRectFigure,{
			constructor : function($) {
				this.outputs = [];
				this.incomes = [];
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.w = 100;
				this.h = 60
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;
				var B = document.createElement("v:roundrect");
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";
				B.setAttribute("arcsize", 0.2);
				B.setAttribute("fillcolor", Interface.CANVAS_FILL);
				B.setAttribute("strokecolor", Interface.CANVAS_STROKE);
				B.setAttribute("strokeweight", "1");
				B.style.verticalAlign = "middle";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				B.appendChild(this.shadow);
				$.appendChild(B);
				this.rectEl = B;
				var _ = this.getTextPosition(this.w, this.h), A = document
					.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				var roundRectFilter = Interface.parentid + "_roundRectFilter_" + Interface.seed;
				//加上阴影
				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", roundRectFilter);
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 8);
				fe2.setAttribute("dy", 8);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				var ma = document.createElementNS(Interface.svgns, "marker");
				ma.setAttribute("id", "forkArrow");
				ma.setAttribute("markerUnits", "userSpaceOnUse");
				ma.setAttribute("markerWidth", 8);
				ma.setAttribute("markerHeight", 8);
				ma.setAttribute("refX", 8);
				ma.setAttribute("refY", 4);
				ma.setAttribute("orient", "auto");
				var map = document.createElementNS(Interface.svgns, "path");
				map.setAttribute("d", "M 0 0 L 8 4 L 0 8 z");
				map.setAttribute("stroke", Interface.CANVAS_STROKE);
				map.setAttribute("fill", Interface.CANVAS_STROKE);
				ma.appendChild(map);
				this.def.appendChild(ma);


				this.shadow = document.createElementNS(Interface.svgns, "rect");
				this.shadow.setAttribute("width", (this.w - 8) + "px");
				this.shadow.setAttribute("height", (this.h - 8) + "px");
				// this.shadow.setAttribute("y", 19);
				this.shadow.setAttribute("rx", 5);
				this.shadow.setAttribute("ry", 5);
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#"+ roundRectFilter + ")");

				$.appendChild(this.def);
				$.appendChild(this.shadow);
				//-------------------------------------------------------------------------
				var Br = document.createElementNS(Interface.svgns, "rect");
				Br.setAttribute("x", 4);
				Br.setAttribute("y", 4);
				Br.setAttribute("width", (this.w - 8) + "px");
				Br.setAttribute("height", (this.h - 8) + "px");
				Br.setAttribute("fill", Interface.CANVAS_FILL);
				Br.setAttribute("stroke-width", "2");
				Br.setAttribute("stroke", Interface.CANVAS_STROKE);
				Br.setAttribute("rx", 6);
				Br.setAttribute("ry", 6);
				$.appendChild(Br);

				var B = document.createElementNS(Interface.svgns, "rect");
				B.setAttribute("x", 25);
				B.setAttribute("y", 20);
				B.setAttribute("width", (this.w - 50) + "px");
				B.setAttribute("height", (this.h - 40) + "px");
				B.setAttribute("rx", 6);
				B.setAttribute("ry", 6);
				B.setAttribute("fill", Interface.CANVAS_STROKE);
				B.setAttribute("stroke", Interface.CANVAS_STROKE);
				B.setAttribute("stroke-width", "1");
				$.appendChild(B);
				this.rectEl = B;

				var L1 = document.createElementNS(Interface.svgns, "line");
				L1.setAttribute("x1", this.w / 2);
				L1.setAttribute("y1", 6);
				L1.setAttribute("x2", this.w / 2);
				L1.setAttribute("y2", 20);
				L1.setAttribute("fill", Interface.CANVAS_STROKE);
				L1.setAttribute("stroke", Interface.CANVAS_STROKE);
				L1.setAttribute("stroke-width", "2");
				L1.setAttribute("marker-end", "url(#forkArrow)");
				$.appendChild(L1);

				var L2 = document.createElementNS(Interface.svgns, "line");
				L2.setAttribute("x1", this.w / 2);
				L2.setAttribute("y1", this.h - 20);
				L2.setAttribute("x2", this.w / 2);
				L2.setAttribute("y2", this.h - 6);
				L2.setAttribute("fill", Interface.CANVAS_STROKE);
				L2.setAttribute("stroke", Interface.CANVAS_STROKE);
				L2.setAttribute("stroke-width", "2");
				L2.setAttribute("marker-end", "url(#forkArrow)");
				$.appendChild(L2);

				var L3 = document.createElementNS(Interface.svgns, "line");
				L3.setAttribute("x1", this.w / 3);
				L3.setAttribute("y1", this.h - 20);
				L3.setAttribute("x2", 20);
				L3.setAttribute("y2", this.h - 8);
				L3.setAttribute("fill", Interface.CANVAS_STROKE);
				L3.setAttribute("stroke", Interface.CANVAS_STROKE);
				L3.setAttribute("stroke-width", "2");
				L3.setAttribute("marker-end", "url(#forkArrow)");
				$.appendChild(L3);

				var L4 = document.createElementNS(Interface.svgns, "line");
				L4.setAttribute("x1", this.w / 3 * 2);
				L4.setAttribute("y1", this.h - 20);
				L4.setAttribute("x2", this.w - 20);
				L4.setAttribute("y2", this.h - 8);
				L4.setAttribute("fill", Interface.CANVAS_STROKE);
				L4.setAttribute("stroke", Interface.CANVAS_STROKE);
				L4.setAttribute("stroke-width", "2");
				L4.setAttribute("marker-end", "url(#forkArrow)");
				$.appendChild(L4);

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElementNS(Interface.svgns, "text");
				A.setAttribute("x", _.x);
				A.setAttribute("y", _.y);
				A.setAttribute("text-anchor", "middle");
				A.setAttribute("style", "fill:"+Interface.CANVAS_FILL);
				A.textContent = "分支";
				$.appendChild(A);

				this.textEl = A
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			getTextPosition : function($, _) {
				if (Interface.isVml)
					return this.getTextPositionVml($, _);
				else
					return this.getTextPositionSvg($, _)
			},
			getTextPositionVml : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			getTextPositionSvg : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2 + _.h / 3;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			hideText : function() {
				this.textEl.style.display = "none"
			},
			// updateAndShowText : function($) {
			// 	this.name = $;
			// 	if (Interface.isVml)
			// 		this.textEl.innerHTML = $;
			// 	else
			// 		this.textEl.textContent = $;
			// 	this.textEl.style.display = ""
			// },
			// cancelEditText : function() {
			// 	this.textEl.style.display = ""
			// },
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				var _ = this.getTextPosition($, A);
				this.textEl.setAttribute("x", _.x);
				this.textEl.setAttribute("y", _.y)
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.JoinNodeFigure = Interface.extend(Interface.figure.RoundRectFigure,{
			constructor : function($) {
				this.outputs = [];
				this.incomes = [];
				Interface.figure.NodeFigure.superclass.constructor.call(this, $);
				this.w = 100;
				this.h = 60
			},
			renderVml : function() {
				var $ = document.createElement("v:group");
				$.style.left = this.x;
				$.style.top = this.y;
				$.style.width = this.w;
				$.style.height = this.h;
				$.setAttribute("coordsize", this.w + "," + this.h);
				this.el = $;
				var B = document.createElement("v:roundrect");
				B.style.position = "absolute";
				B.style.left = "5px";
				B.style.top = "5px";
				B.style.width = (this.w - 10) + "px";
				B.style.height = (this.h - 10) + "px";
				B.setAttribute("arcsize", 0.2);
				B.setAttribute("fillcolor", Interface.CANVAS_FILL);
				B.setAttribute("strokecolor", Interface.CANVAS_STROKE);
				B.setAttribute("strokeweight", "1");
				B.style.verticalAlign = "middle";

				//加上阴影
				//<v:shadow on="T" type="single" color="#b3b3b3" offset="5px,5px"/>
				this.shadow = document.createElement("v:shadow");
				this.shadow.setAttribute("on", "T");
				this.shadow.setAttribute("type", "single");
				this.shadow.setAttribute("color", "#b3b3b3");
				this.shadow.setAttribute("offset", "3px,3px");
				B.appendChild(this.shadow);
				$.appendChild(B);
				this.rectEl = B;
				var _ = this.getTextPosition(this.w, this.h), A = document
					.createElement("v:textbox");
				A.style.textAlign = "center";
				A.style.fontFamily = "Verdana";
				A.style.fontSize = "12px";
				A.innerHTML = this.name;
				B.appendChild(A);
				this.textEl = A
			},
			renderSvg : function() {
				var $ = document.createElementNS(Interface.svgns, "g");
				$.setAttribute("transform", "translate(" + this.x + "," + this.y + ")");
				this.el = $;

				var roundRectFilter = Interface.parentid + "_roundRectFilter_" + Interface.seed;
				//加上阴影
				this.def = document.createElementNS(Interface.svgns, "defs");
				this.svgfilter = document.createElementNS(Interface.svgns, "filter");
				this.svgfilter.setAttribute("id", roundRectFilter);
				this.svgfilter.setAttribute("x", "0");
				this.svgfilter.setAttribute("y", "0");

				var fe1 = document.createElementNS(Interface.svgns, "feGaussianBlur");
				fe1.setAttribute("stdDeviation", 2);
				var fe2 = document.createElementNS(Interface.svgns, "feOffset");
				fe2.setAttribute("dx", 8);
				fe2.setAttribute("dy", 8);
				this.svgfilter.appendChild(fe1);
				this.svgfilter.appendChild(fe2);
				this.def.appendChild(this.svgfilter);

				var ma = document.createElementNS(Interface.svgns, "marker");
				ma.setAttribute("id", "forkArrow");
				ma.setAttribute("markerUnits", "userSpaceOnUse");
				ma.setAttribute("markerWidth", 8);
				ma.setAttribute("markerHeight", 8);
				ma.setAttribute("refX", 8);
				ma.setAttribute("refY", 4);
				ma.setAttribute("orient", "auto");
				var map = document.createElementNS(Interface.svgns, "path");
				map.setAttribute("d", "M 0 0 L 8 4 L 0 8 z");
				map.setAttribute("stroke", Interface.CANVAS_STROKE);
				map.setAttribute("fill", Interface.CANVAS_STROKE);
				ma.appendChild(map);
				this.def.appendChild(ma);

				this.shadow = document.createElementNS(Interface.svgns, "rect");
				this.shadow.setAttribute("width", (this.w - 8) + "px");
				this.shadow.setAttribute("height", (this.h - 8) + "px");
				// this.shadow.setAttribute("x", 5);
				// this.shadow.setAttribute("y", 19);
				this.shadow.setAttribute("rx", 5);
				this.shadow.setAttribute("ry", 5);
				this.shadow.setAttribute("fill", "grey");
				this.shadow.setAttribute("filter", "url(#"+ roundRectFilter + ")");

				$.appendChild(this.def);
				$.appendChild(this.shadow);
				//-------------------------------------------------------------------------

				var Br = document.createElementNS(Interface.svgns, "rect");
				Br.setAttribute("x", 4);
				Br.setAttribute("y", 4);
				Br.setAttribute("width", (this.w - 8) + "px");
				Br.setAttribute("height", (this.h - 8) + "px");
				Br.setAttribute("fill", Interface.CANVAS_FILL);
				Br.setAttribute("stroke-width", "2");
				Br.setAttribute("stroke", Interface.CANVAS_STROKE);
				Br.setAttribute("rx", 6);
				Br.setAttribute("ry", 6);
				$.appendChild(Br);

				var B = document.createElementNS(Interface.svgns, "rect");
				B.setAttribute("x", 25);
				B.setAttribute("y", 20);
				B.setAttribute("width", (this.w - 50) + "px");
				B.setAttribute("height", (this.h - 40) + "px");
				B.setAttribute("rx", 6);
				B.setAttribute("ry", 6);
				B.setAttribute("fill", Interface.CANVAS_STROKE);
				B.setAttribute("stroke", Interface.CANVAS_STROKE);
				B.setAttribute("stroke-width", "1");
				$.appendChild(B);
				this.rectEl = B;

				var L1 = document.createElementNS(Interface.svgns, "line");
				L1.setAttribute("x1", this.w / 2);
				L1.setAttribute("y1", 6);
				L1.setAttribute("x2", this.w / 2);
				L1.setAttribute("y2", 20);
				L1.setAttribute("fill", Interface.CANVAS_STROKE);
				L1.setAttribute("stroke", Interface.CANVAS_STROKE);
				L1.setAttribute("stroke-width", "2");
				L1.setAttribute("marker-end", "url(#forkArrow)");
				$.appendChild(L1);

				var L2 = document.createElementNS(Interface.svgns, "line");
				L2.setAttribute("x1", this.w / 2);
				L2.setAttribute("y1", this.h - 20);
				L2.setAttribute("x2", this.w / 2);
				L2.setAttribute("y2", this.h - 6);
				L2.setAttribute("fill", Interface.CANVAS_STROKE);
				L2.setAttribute("stroke", Interface.CANVAS_STROKE);
				L2.setAttribute("stroke-width", "2");
				L2.setAttribute("marker-end", "url(#forkArrow)");
				$.appendChild(L2);

				var L3 = document.createElementNS(Interface.svgns, "line");
				L3.setAttribute("x1", 16);
				L3.setAttribute("y1", 6);
				L3.setAttribute("x2", this.w / 3);
				L3.setAttribute("y2", 18);
				L3.setAttribute("fill", Interface.CANVAS_STROKE);
				L3.setAttribute("stroke", Interface.CANVAS_STROKE);
				L3.setAttribute("stroke-width", "2");
				L3.setAttribute("marker-end", "url(#forkArrow)");
				$.appendChild(L3);

				var L4 = document.createElementNS(Interface.svgns, "line");
				L4.setAttribute("x1", this.w - 16);
				L4.setAttribute("y1", 6);
				L4.setAttribute("x2", this.w / 3 * 2);
				L4.setAttribute("y2", 18);
				L4.setAttribute("fill", Interface.CANVAS_STROKE);
				L4.setAttribute("stroke", Interface.CANVAS_STROKE);
				L4.setAttribute("stroke-width", "2");
				L4.setAttribute("marker-end", "url(#forkArrow)");
				$.appendChild(L4);

				var _ = this.getTextPosition(this.w, this.h),
					A = document.createElementNS(Interface.svgns, "text");
				A.setAttribute("x", _.x);
				A.setAttribute("y", _.y);
				A.setAttribute("text-anchor", "middle");
				A.setAttribute("style", "fill:"+Interface.CANVAS_FILL);
				A.textContent = "合并";
				$.appendChild(A);

				this.textEl = A
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.getParentEl().appendChild(this.el)
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("cursor", "pointer");
				this.getParentEl().appendChild(this.el)
			},
			getTextPosition : function($, _) {
				if (Interface.isVml)
					return this.getTextPositionVml($, _);
				else
					return this.getTextPositionSvg($, _)
			},
			getTextPositionVml : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			getTextPositionSvg : function($, B) {
				var _ = Interface.getTextSize(this.name), C = $ / 2, A = B / 2 + _.h / 3;
				return {
					x : C + "px",
					y : A + "px"
				}
			},
			moveTo : function(B, _) {
				Interface.NodeFigure.superclass.moveTo.call(this, B, _);
				for (var A = 0; A < this.incomes.length; A++) {
					var $ = this.incomes[A];
					$.refresh()
				}
				for (A = 0; A < this.outputs.length; A++) {
					$ = this.outputs[A];
					$.refresh()
				}
			},
			moveToVml : function() {
				this.el.style.left = this.x + "px";
				this.el.style.top = this.y + "px"
			},
			moveToSvg : function($, _) {
				this.el.setAttribute("transform", "translate(" + this.x + "," + this.y + ")")
			},
			update : function(B, A, $, _) {
				this.x = B;
				this.y = A;
				this.w = $;
				this.h = _;
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.NodeFigure.superclass.remove.call(this)
			},
			hideText : function() {
				this.textEl.style.display = "none"
			},
			// updateAndShowText : function($) {
			// 	this.name = $;
			// 	if (Interface.isVml)
			// 		this.textEl.innerHTML = $;
			// 	else
			// 		this.textEl.textContent = $;
			// 	this.textEl.style.display = ""
			// },
			// cancelEditText : function() {
			// 	this.textEl.style.display = ""
			// },
			resize : function(B, _, A) {
				var E = this.x, D = this.y, $ = this.w, C = this.h;
				if (B == "n") {
					D = D + A;
					C = C - A
				} else if (B == "s")
					C = C + A;
				else if (B == "w") {
					E = E + _;
					$ = $ - _
				} else if (B == "e")
					$ = $ + _;
				else if (B == "nw") {
					E = E + _;
					$ = $ - _;
					D = D + A;
					C = C - A
				} else if (B == "ne") {
					$ = $ + _;
					D = D + A;
					C = C - A
				} else if (B == "sw") {
					E = E + _;
					$ = $ - _;
					C = C + A
				} else if (B == "se") {
					$ = $ + _;
					C = C + A
				}
				if (Interface.isVml)
					this.resizeVml(E, D, $, C);
				else
					this.resizeSvg(E, D, $, C);
				return {
					x : E,
					y : D,
					w : $,
					h : C
				}
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = ($ - 10) + "px";
				this.rectEl.style.height = (_ - 10) + "px"
			},
			resizeSvg : function(C, B, $, A) {
				this.el.setAttribute("transform", "translate(" + C + "," + B + ")");
				var _ = this.getTextPosition($, A);
				this.textEl.setAttribute("x", _.x);
				this.textEl.setAttribute("y", _.y)
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.ImageNodeFigure = Interface.extend(Interface.figure.ImaInterfaceigure, {
			constructor : function($) {
				this.w = 48;
				this.h = 48;
				this.outputs = [];
				this.incomes = [];
				Interface.figure.ImageNodeFigure.superclass.constructor.call(this, $)
			},
			move : function(_, A) {
				Interface.figure.ImageNodeFigure.superclass.move.call(this, _, A);
				for (var B = 0; B < this.incomes.length; B++) {
					var $ = this.incomes[B];
					$.refresh()
				}
				for (B = 0; B < this.outputs.length; B++) {
					$ = this.outputs[B];
					$.refresh()
				}
			},
			remove : function() {
				for (var _ = this.outputs.length - 1; _ >= 0; _--) {
					var $ = this.outputs[_];
					$.remove()
				}
				for (_ = this.incomes.length - 1; _ >= 0; _--) {
					$ = this.incomes[_];
					$.remove()
				}
				Interface.figure.ImageNodeFigure.superclass.remove.call(this)
			},
			getTools : function() {
				return []
			}
		});
		Interface.figure.EdInterfaceigure = Interface.extend(Interface.figure.PolylineFigure, {
			constructor : function(_, $) {
				this.from = _;
				this.to = $;
				if (!this.name)
					this.name = "to " + $.name;
				this.from.outputs.push(this);
				this.to.incomes.push(this);
				this.alive = true;
				this.innerPoints = [];
				this.calculate();
				Interface.figure.EdInterfaceigure.superclass.constructor.call(this, {});
				this.textX = 0;
				this.textY = 0
			},
			render : function() {
				this.calculate();
				Interface.figure.EdInterfaceigure.superclass.render.call(this)
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "pointer";
				this.el.setAttribute("strokeweight", 2);
				this.el.setAttribute("strokecolor", "#909090");
				this.getParentEl().appendChild(this.el);
				this.stroke = document.createElement("v:stroke");
				this.el.appendChild(this.stroke);
				this.stroke.setAttribute("endArrow", "Classic");
				var _ = document.createElement("textbox"), $ = this.getTextLocation();
				_.style.position = "absolute";
				_.style.left = $.x + "px";
				_.style.top = ($.y - $.h) + "px";
				_.style.textAlign = "center";
				_.style.cursor = "pointer";
				_.style.fontFamily = "Verdana";
				_.style.fontSize = "12px";
				_.innerHTML = this.name;
				_.setAttribute("edgeId", this.getId());
				this.getParentEl().appendChild(_);
				this.textEl = _
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("fill", "none");
				this.el.setAttribute("stroke", "#909090");
				this.el.setAttribute("stroke-width", "2");
				this.el.setAttribute("cursor", "pointer");
				this.el.setAttribute("marker-end", "url(#"+Interface.parentid + "_markerArrow)");
				this.getParentEl().appendChild(this.el);
				var _ = document.createElementNS(Interface.svgns, "text"),
					$ = this.getTextLocation();
				_.setAttribute("x", $.x);
				_.setAttribute("y", $.y);
				_.setAttribute("cursor", "pointer");
				_.textContent = this.name;
				_.setAttribute("edgeId", this.getId());
				this.getParentEl().appendChild(_);
				this.textEl = _
			},
			setConditional : function($) {
				if (Interface.isVml)
					this.setConditionalVml($);
				else
					this.setConditionalSvg($)
			},
			setConditionalVml : function($) {
				if ($ == true)
					this.stroke.setAttribute("startArrow", "diamond");
				else
					this.stroke.setAttribute("startArrow", "")
			},
			setConditionalSvg : function($) {
				if ($ == true)
					this.el.setAttribute("marker-start", "url(#"+Interface.parentid + "_markerDiamond)");
				else
					this.el.setAttribute("marker-start", "")
			},
			calculate : function() {
				var A = new Interface.Geom.Line(this.from.x + this.from.w / 2, this.from.y + this.from.h / 2, this.to.x + this.to.w / 2, this.to.y + this.to.h / 2),
					C = new Interface.Geom.Rect(this.from.x, this.from.y, this.from.w, this.from.h),
					B = new Interface.Geom.Rect(this.to.x,this.to.y, this.to.w, this.to.h),
					_ = C.getCrossPoint(A), $ = B.getCrossPoint(A);
				if (_ == null || $ == null) {
					this.x1 = 0;
					this.y1 = 0;
					this.x2 = 0;
					this.y2 = 0
				} else {
					this.x1 = _.x;
					this.y1 = _.y;
					this.x2 = $.x;
					this.y2 = $.y
				}
				this.convert()
			},
			recalculate : function(_, $) {
				var B = new Interface.Geom.Line(_.x + _.w / 2, _.y + _.h / 2, $[0], $[1]),
					C = new Interface.Geom.Rect(_.x, _.y, _.w, _.h), A = C.getCrossPoint(B);
				return A
			},
			convert : function() {
				this.points = [];
				var _ = this.points, A = this.innerPoints.length;
				if (A > 0) {
					var $ = this.recalculate(this.from, this.innerPoints[0]);
					this.x1 = $.x;
					this.y1 = $.y
				}
				_.push([this.x1, this.y1]);
				for (var B = 0; B < this.innerPoints.length; B++)
					_.push([this.innerPoints[B][0], this.innerPoints[B][1]]);
				if (A > 0) {
					$ = this.recalculate(this.to, this.innerPoints[A - 1]);
					if ($ != null) {
						this.x2 = $.x;
						this.y2 = $.y
					}
				}
				_.push([this.x2, this.y2])
			},
			update : function(B, $, A, _) {
				this.x1 = B;
				this.y1 = $;
				this.x2 = A;
				this.y2 = _;
				if (Interface.isVml)
					this.updateVml();
				else
					this.updateSvg()
			},
			updateVml : function() {
				this.el.points.value = this.getPoint(0, 0);
				var $ = this.getTextLocation();
				this.textEl.style.left = $.x + "px";
				this.textEl.style.top = ($.y - $.h) + "px"
			},
			updateSvg : function() {
				this.el.setAttribute("points", this.getPoint(0, 0));
				var $ = this.getTextLocation();
				this.textEl.setAttribute("x", $.x);
				this.textEl.setAttribute("y", $.y)
			},
			refresh : function() {
				if (!this.el)
					this.render();
				this.calculate();
				this.update(this.x1, this.y1, this.x2, this.y2)
			},
			getTextLocation : function() {
				var _ = Interface.getTextSize(this.name), $ = _.w + 2, B = _.h + 2,
					C = (this.x1 + this.x2) / 2 + this.textX,
					A = (this.y1 + this.y2) / 2 + this.textY;
				return {
					x : C,
					y : A,
					w : $,
					h : B
				}
			},
			updateAndShowText : function(_) {
				this.name = _;
				if (Interface.isVml) {
					this.textEl.innerHTML = _;
					var $ = this.getTextLocation();
					this.textEl.style.left = $.x;
					this.textEl.style.top = $.y
				} else
					this.textEl.textContent = _;
				this.textEl.style.display = ""
			},
			remove : function() {
				if (this.alive) {
					this.from.outputs.remove(this);
					this.to.incomes.remove(this);
					this.getParentEl().removeChild(this.el);
					this.getParentEl().removeChild(this.textEl);
					this.alive = false
				}
			},
			modify : function() {
				this.convert();
				if (Interface.isVml)
					this.el.points.value = this.getPoint(0, 0);
				else
					this.el.setAttribute("points", this.getPoint(0, 0));
				this.refresh()
			}
		});
		Interface.figure.DraggingRectFigure = Interface.extend(Interface.figure.RectFigure, {
			constructor : function($) {
				Interface.figure.DraggingRectFigure.superclass.constructor.call(this, $);
				this._className = "Interface.DraggingRectFigure"
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "normal";
				this.getParentEl().appendChild(this.el);
				this.stroke = document.createElement("v:stroke");
				this.el.appendChild(this.stroke);
				this.stroke.setAttribute("strokecolor", "black");
				this.stroke.setAttribute("dashstyle", "dot");
				this.fill = document.createElement("v:fill");
				this.el.appendChild(this.fill);
				this.fill.setAttribute("color", "#F6F6F6");
				this.fill.setAttribute("opacity", "0.5")
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("fill", "#F6F6F6");
				this.el.setAttribute("opacity", "0.7");
				this.el.setAttribute("stroke", "black");
				this.el.setAttribute("stroke-width", "1");
				this.el.setAttribute("cursor", "normal");
				this.el.setAttribute("stroke-dasharray", "2");
				this.getParentEl().appendChild(this.el)
			},
			update : function(E, D, $, C) {
				var B = this.x, A = this.y, _ = {
					x : E,
					y : D,
					w : $,
					h : C
				};
				if ($ < 0) {
					this.oldX = this.x;
					_.x = E + $;
					_.w = -$
				}
				if (C < 0) {
					_.y = D + C;
					_.h = -C
				}
				Interface.figure.DraggingRectFigure.superclass.update.call(this, _.x, _.y, _.w, _.h);
				if ($ < 0)
					this.x = B;
				if (C < 0)
					this.y = A
			}
		});
		Interface.figure.DraggingEdInterfaceigure = Interface.extend(Interface.figure.EdInterfaceigure, {
			constructor : function($) {
				Interface.figure.DraggingEdInterfaceigure.superclass.constructor.call(this, {
																						  outputs: []
																					  },
																					  {
																						  incomes: []
																					  });
				this._className = "Interface.DraggingEdInterfaceigure"
			},
			onRenderVml : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.style.position = "absolute";
				this.el.style.cursor = "normal";
				this.getParentEl().appendChild(this.el);
				this.stroke = document.createElement("v:stroke");
				this.el.appendChild(this.stroke);
				this.stroke.color = "#909090";
				this.stroke.dashstyle = "dot";
				this.stroke.endArrow = "Classic";
				this.stroke.weight = 2
			},
			onRenderSvg : function() {
				this.el.setAttribute("id", Interface.id());
				this.el.setAttribute("fill", "none");
				this.el.setAttribute("stroke", "#909090");
				this.el.setAttribute("stroke-width", "2");
				this.el.setAttribute("cursor", "normal");
				this.el.setAttribute("stroke-dasharray", "2");
				this.el.setAttribute("marker-end", "url(#"+Interface.parentid + "_markerArrow)");
				this.getParentEl().appendChild(this.el)
			},
			updateForDragging : function(_, $) {
				this.from = _;
				this.x1 = this.from.x;
				this.y1 = this.from.y;
				this.to = {
					x : $.x,
					y : $.y,
					w : 2,
					h : 2
				};
				this.x2 = this.to.x;
				this.y2 = this.to.y;
				if(!this.innerPoints)
					this.innerPoints = [];
				this.refresh()
			},
			updateForMove : function($, _, A) {
				if (_ == "start") {
					this.from = {
						x : A.x,
						y : A.y,
						w : 2,
						h : 2
					};
					this.x1 = A.x;
					this.y1 = A.y;
					this.to = $.to;
					this.x2 = $.x2;
					this.y2 = $.y2
				} else {
					this.from = $.from;
					this.x1 = $.x1;
					this.y1 = $.y1;
					this.to = {
						x : A.x,
						y : A.y,
						w : 2,
						h : 2
					};
					this.x2 = A.x;
					this.y2 = A.y
				}
				this.innerPoints = $.innerPoints;
				this.refresh()
			},
			moveToHide : function() {
				this.from = null;
				this.to = null;
				this.innerPoints = null;
				this.points = [[-1, -1], [-1, -1]];
				this.update(-1, -1, -1, -1)
			},
			updateVml : function() {
				this.el.points.value = this.getPoint(0, 0)
			},
			updateSvg : function() {
				this.el.setAttribute("points", this.getPoint(0, 0))
			}
		});
		Interface.figure.DraggingTextFigure = Interface.extend(Interface.figure.Figure, {
			constructor : function($) {
				Interface.figure.DraggingTextFigure.superclass.constructor.call(this);
				this.edge = $
			},
			getTextLocation : function() {
				var _ = this.edge.getTextLocation(), E = _.x - 3, D = _.y + 4, $ = _.w + 6, C = _.h + 4, B = $ / 2, A = C / 2;
				D -= C;
				return {
					x : E,
					y : D,
					w : $,
					h : C,
					cx : B,
					cy : A
				}
			},
			renderVml : function() {
				var A = this.getTextLocation(), G = A.x, F = A.y, $ = A.w + 6, E = A.h + 5, C = A.cx, B = A.cy,
					_ = document.createElement("v:group");
				_.style.left = G;
				_.style.top = F;
				_.style.width = $;
				_.style.height = E;
				_.setAttribute("coordsize", $ + "," + E);
				this.el = _;
				var D = document.createElement("v:rect");
				D.filled = "f";
				D.strokecolor = "black";
				D.style.left = "0px";
				D.style.top = "0px";
				D.style.width = $ + "px";
				D.style.height = E + "px";
				_.appendChild(D);
				this.rectEl = D;
				this.nwEl = this.createItemVml(0, 0, "nw");
				this.neEl = this.createItemVml($, 0, "ne");
				this.swEl = this.createItemVml(0, E, "sw");
				this.seEl = this.createItemVml($, E, "se")
			},
			createItemVml : function(B, A, $) {
				var _ = document.createElement("v:rect");
				_.id = this.edge.getId() + ":" + $;
				_.fillcolor = "black";
				_.style.cursor = $ + "-resize";
				_.style.left = (B - 2) + "px";
				_.style.top = (A - 2) + "px";
				_.style.width = "4px";
				_.style.height = "4px";
				this.el.appendChild(_);
				return _
			},
			renderSvg : function() {
				var A = this.getTextLocation(), G = A.x, F = A.y, $ = A.w + 6, E = A.h + 5, C = A.cx, B = A.cy,
					_ = document.createElementNS(Interface.svgns, "g");
				_.setAttribute("transform", "translate(" + G + "," + F + ")");
				this.el = _;
				var D = document.createElementNS(Interface.svgns, "rect");
				D.setAttribute("x", 0);
				D.setAttribute("y", 0);
				D.setAttribute("width", $);
				D.setAttribute("height", E);
				D.setAttribute("fill", "none");
				D.setAttribute("stroke", "black");
				this.rectEl = D;
				this.el.appendChild(D);
				this.nwEl = this.createItemSvg(0, 0, "nw");
				this.neEl = this.createItemSvg($, 0, "ne");
				this.swEl = this.createItemSvg(0, E, "sw");
				this.seEl = this.createItemSvg($, E, "se")
			},
			createItemSvg : function(B, A, $) {
				var _ = document.createElementNS(Interface.svgns, "rect");
				_.setAttribute("id", this.edge.getId() + ":" + $);
				_.setAttribute("cursor", $ + "-resize");
				_.setAttribute("x", B - 2);
				_.setAttribute("y", A - 2);
				_.setAttribute("width", "5");
				_.setAttribute("height", "5");
				_.setAttribute("fill", "black");
				_.setAttribute("stroke", "white");
				this.el.appendChild(_);
				return _
			},
			resize : function(B, $, A, _) {
				if (Interface.isVml)
					this.resizeVml(B, $, A, _);
				else
					this.resizeSvg(B, $, A, _)
			},
			resizeVml : function(I, A, E, C) {
				var _ = this.getTextLocation(), H = _.x, G = _.y, $ = _.w, F = _.h, D = _.cx, B = _.cy;
				this.el.style.left = H + "px";
				this.el.style.top = G + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = F + "px";
				this.el.coordsize = $ + "," + F;
				this.rectEl.style.width = $ + "px";
				this.rectEl.style.height = F + "px";
				this.neEl.style.left = ($ - 2) + "px";
				this.swEl.style.top = (F - 2) + "px";
				this.seEl.style.left = ($ - 2) + "px";
				this.seEl.style.top = (F - 2) + "px"
			},
			resizeSvg : function(I, A, E, C) {
				var _ = this.getTextLocation(), H = _.x, G = _.y, $ = _.w, F = _.h, D = _.cx, B = _.cy;
				this.el.setAttribute("transform", "translate(" + H + "," + G + ")");
				this.rectEl.setAttribute("width", $);
				this.rectEl.setAttribute("height", F);
				this.neEl.setAttribute("x", $ - 2);
				this.swEl.setAttribute("y", F - 2);
				this.seEl.setAttribute("x", $ - 2);
				this.seEl.setAttribute("y", F - 2)
			},
			refresh : function() {
				this.resize(this.edge.x1, this.edge.y1, this.edge.x2, this.edge.y2);
				this.updateAndShowText()
			},
			updateAndShowText : function() {
				var _ = this.edge.getTextLocation(), C = _.x, B = _.y, $ = _.w, A = _.h;
				if (Interface.isVml) {
					this.edge.textEl.style.left = C + "px";
					this.edge.textEl.style.top = (B - A) + "px"
				} else {
					this.edge.textEl.setAttribute("x", C);
					this.edge.textEl.setAttribute("y", B)
				}
			}
		});
		Interface.figure.ResizeNodeHandle = Interface.extend(Interface.figure.Figure, {
			constructor : function($) {
				this.children = [];
				this.node = $
			},
			renderVml : function() {
				var _ = this.node, G = _.x, F = _.y, $ = _.w, E = _.h, C = $ / 2, B = E / 2, A = document.createElement("v:group");
				A.style.left = G;
				A.style.top = F;
				A.style.width = $;
				A.style.height = E;
				A.setAttribute("coordsize", $ + "," + E);
				this.el = A;
				var D = document.createElement("v:rect");
				D.filled = "f";
				D.strokecolor = "black";
				D.style.left = "0px";
				D.style.top = "0px";
				D.style.width = $ + "px";
				D.style.height = E + "px";
				A.appendChild(D);
				this.rectEl = D;
				this.nEl = this.createItemVml(C, 0, "n");
				this.sEl = this.createItemVml(C, E, "s");
				this.wEl = this.createItemVml(0, B, "w");
				this.eEl = this.createItemVml($, B, "e");
				this.nwEl = this.createItemVml(0, 0, "nw");
				this.neEl = this.createItemVml($, 0, "ne");
				this.swEl = this.createItemVml(0, E, "sw");
				this.seEl = this.createItemVml($, E, "se");
				Interface.each(_.getTools(), function($) {
					$.render(A, _)
				})
			},
			createItemVml : function(B, A, $) {
				var _ = document.createElement("v:rect");
				_.id = this.node.getId() + ":" + $;
				_.fillcolor = "black";
				_.strokecolor = "white";
				_.style.cursor = $ + "-resize";
				_.style.left = (B - 2) + "px";
				_.style.top = (A - 2) + "px";
				_.style.width = "5px";
				_.style.height = "5px";
				this.el.appendChild(_);
				return _
			},
			renderSvg : function() {
				var _ = this.node, G = _.x, F = _.y, $ = _.w, E = _.h, C = $ / 2, B = E / 2, A = document.createElementNS(Interface.svgns, "g");
				A.setAttribute("transform", "translate(" + G + "," + F + ")");
				this.el = A;
				var D = document.createElementNS(Interface.svgns, "rect");
				D.setAttribute("x", 0);
				D.setAttribute("y", 0);
				D.setAttribute("width", $);
				D.setAttribute("height", E);
				D.setAttribute("fill", "none");
				D.setAttribute("stroke", "black");
				this.rectEl = D;
				this.el.appendChild(D);
				this.nEl = this.createItemSvg(C, 0, "n");
				this.sEl = this.createItemSvg(C, E, "s");
				this.wEl = this.createItemSvg(0, B, "w");
				this.eEl = this.createItemSvg($, B, "e");
				this.nwEl = this.createItemSvg(0, 0, "nw");
				this.neEl = this.createItemSvg($, 0, "ne");
				this.swEl = this.createItemSvg(0, E, "sw");
				this.seEl = this.createItemSvg($, E, "se");
				Interface.each(_.getTools(), function($) {
					$.render(A, _)
				})
			},
			createItemSvg : function(B, A, $) {
				var _ = document.createElementNS(Interface.svgns, "rect");
				_.setAttribute("id", this.node.getId() + ":" + $);
				_.setAttribute("cursor", $ + "-resize");
				_.setAttribute("x", B - 2);
				_.setAttribute("y", A - 2);
				_.setAttribute("width", "5");
				_.setAttribute("height", "5");
				_.setAttribute("fill", "black");
				_.setAttribute("stroke", "white");
				this.el.appendChild(_);
				return _
			},
			resize : function(B, A, $, _) {
				if (Interface.isVml)
					this.resizeVml(B, A, $, _);
				else
					this.resizeSvg(B, A, $, _)
			},
			resizeVml : function(B, A, $, _) {
				this.el.style.left = B + "px";
				this.el.style.top = A + "px";
				this.el.style.width = $ + "px";
				this.el.style.height = _ + "px";
				this.el.coordsize = $ + "," + _;
				this.rectEl.style.width = $ + "px";
				this.rectEl.style.height = _ + "px";
				this.nEl.style.left = ($ / 2 - 2) + "px";
				this.sEl.style.left = ($ / 2 - 2) + "px";
				this.sEl.style.top = (_ - 2) + "px";
				this.wEl.style.top = (_ / 2 - 2) + "px";
				this.eEl.style.left = ($ - 2) + "px";
				this.eEl.style.top = (_ / 2 - 2) + "px";
				this.neEl.style.left = ($ - 2) + "px";
				this.swEl.style.top = (_ - 2) + "px";
				this.seEl.style.left = ($ - 2) + "px";
				this.seEl.style.top = (_ - 2) + "px";
				Interface.each(this.node.getTools(), function(C) {
					C.resize(B, A, $, _)
				})
			},
			resizeSvg : function(B, A, $, _) {
				this.el.setAttribute("transform", "translate(" + B + "," + A + ")");
				this.rectEl.setAttribute("width", $);
				this.rectEl.setAttribute("height", _);
				this.nEl.setAttribute("x", $ / 2 - 2);
				this.sEl.setAttribute("x", $ / 2 - 2);
				this.sEl.setAttribute("y", _ - 2);
				this.wEl.setAttribute("y", _ / 2 - 2);
				this.eEl.setAttribute("x", $ - 2);
				this.eEl.setAttribute("y", _ / 2 - 2);
				this.neEl.setAttribute("x", $ - 2);
				this.swEl.setAttribute("y", _ - 2);
				this.seEl.setAttribute("x", $ - 2);
				this.seEl.setAttribute("y", _ - 2);
				Interface.each(this.node.getTools(), function(C) {
					C.resize(B, A, $, _)
				})
			},
			refresh : function() {
				this.resize(this.node.x, this.node.y, this.node.w, this.node.h)
			}
		});
		Interface.figure.ResizeEdgeHandle = Interface.extend(Interface.figure.Figure, {
			renderVml : function() {
				var F = this.edge.x1, A = this.edge.y1, D = this.edge.x2, B = this.edge.y2, C = this.edge.innerPoints, H = Math
					.max(F, D), E = Math.max(A, B), I = document.createElement("v:group");
				I.style.width = H + "px";
				I.style.height = E + "px";
				I.setAttribute("coordsize", H + "," + E);
				this.getParentEl().appendChild(I);
				this.el = I;
				var K = document.createElement("v:polyline");
				K.setAttribute("points", this.edge.getPoint(0, 0));
				K.filled = "false";
				K.strokeweight = "2";
				K.strokecolor = "black";
				K.style.position = "absolute";
				I.appendChild(K);
				this.lineEl = K;
				this.startEl = this.createItem(F, A, "start");
				this.endEl = this.createItem(D, B, "end");
				var G = 0, _ = [F, A], J = [];
				for (; G < C.length; G++) {
					var $ = C[G];
					J.push(this.createItem((_[0] + $[0]) / 2, (_[1] + $[1]) / 2, "middle:" + (G - 1) + "," + G));
					_ = $;
					J.push(this.createItem($[0], $[1], "middle:" + G + "," + G))
				}
				J.push(this.createItem((_[0] + D) / 2, (_[1] + B) / 2, "middle:" + (G - 1) + "," + G));
				this.items = J
			},
			renderSvg : function() {
				var I = this.edge.x1, C = this.edge.y1, G = this.edge.x2, D = this.edge.y2, E = this.edge.innerPoints,
					$ = document.createElementNS(Interface.svgns, "g");
				this.getParentEl().appendChild($);
				this.el = $;
				var F = document.createElementNS(Interface.svgns, "polyline");
				F.setAttribute("points", this.edge.getPoint(0, 0));
				F.setAttribute("fill", "none");
				F.setAttribute("stroke", "black");
				F.setAttribute("stroke-width", "2");
				$.appendChild(F);
				this.lineEl = F;
				this.startEl = this.createItem(I, C, "start");
				this.endEl = this.createItem(G, D, "end");
				var H = 0, B = [I, C], A = [];
				for (; H < E.length; H++) {
					var _ = E[H];
					A.push(this.createItem((B[0] + _[0]) / 2, (B[1] + _[1]) / 2, "middle:" + (H - 1) + "," + H));
					B = _;
					A.push(this.createItem(_[0], _[1], "middle:" + H + "," + H))
				}
				A.push(this.createItem((B[0] + G) / 2, (B[1] + D) / 2, "middle:" + (H - 1) + "," + H));
				this.items = A
			},
			createItem : function(A, _, $) {
				if (Interface.isVml)
					return this.createItemVml(A, _, $);
				else
					return this.createItemSvg(A, _, $)
			},
			createItemVml : function(B, A, _) {
				var $ = document.createElement("v:rect");
				$.id = this.edge.getId() + ":" + _;
				$.fillcolor = "black";
				$.strokecolor = "white";
				$.style.left = (B - 2) + "px";
				$.style.top = (A - 2) + "px";
				$.style.width = "5px";
				$.style.height = "5px";
				$.style.cursor = "move";
				this.el.appendChild($);
				return $
			},
			createItemSvg : function(B, A, _) {
				var $ = document.createElementNS(Interface.svgns, "rect");
				$.setAttribute("id", this.edge.getId() + ":" + _);
				$.setAttribute("x", B - 2);
				$.setAttribute("y", A - 2);
				$.setAttribute("width", 5);
				$.setAttribute("height", 5);
				$.setAttribute("fill", "black");
				$.setAttribute("stroke", "white");
				$.setAttribute("cursor", "move");
				this.el.appendChild($);
				return $
			},
			update : function() {
				if (Interface.isVml)
					this.updateVml();
				else
					this.updateSvg()
			},
			updateVml : function() {
				var G = this.edge.x1, _ = this.edge.y1, D = this.edge.x2, A = this.edge.y2;
				this.lineEl.points.value = this.edge.getPoint(0, 0);
				this.startEl.style.left = (G - 2) + "px";
				this.startEl.style.top = (_ - 2) + "px";
				this.endEl.style.left = (D - 2) + "px";
				this.endEl.style.top = (A - 2) + "px";
				var B = this.edge.innerPoints, F = 0, C = G, E = _;
				for (; F < B.length; F++) {
					var $ = B[F];
					this.items[F * 2].style.left = ((C + $[0]) / 2 - 2) + "px";
					this.items[F * 2].style.top = ((E + $[1]) / 2 - 2) + "px";
					C = $[0];
					E = $[1];
					this.items[F * 2 + 1].style.left = ($[0] - 2) + "px";
					this.items[F * 2 + 1].style.top = ($[1] - 2) + "px"
				}
				this.items[F * 2].style.left = ((C + D) / 2 - 2) + "px";
				this.items[F * 2].style.top = ((E + A) / 2 - 2) + "px"
			},
			updateSvg : function() {
				var G = this.edge.x1, _ = this.edge.y1, D = this.edge.x2, A = this.edge.y2;
				this.lineEl.setAttribute("points", this.edge.getPoint(0, 0));
				this.startEl.setAttribute("x", G - 2);
				this.startEl.setAttribute("y", _ - 2);
				this.endEl.setAttribute("x", D - 2);
				this.endEl.setAttribute("y", A - 2);
				var B = this.edge.innerPoints, F = 0, C = G, E = _;
				for (; F < B.length; F++) {
					var $ = B[F];
					this.items[F * 2].setAttribute("x", (C + $[0]) / 2 - 2);
					this.items[F * 2].setAttribute("y", (E + $[1]) / 2 - 2);
					C = $[0];
					E = $[1];
					this.items[F * 2 + 1].setAttribute("x", $[0] - 2);
					this.items[F * 2 + 1].setAttribute("y", $[1] - 2)
				}
				this.items[F * 2].setAttribute("x", (C + D) / 2 - 2);
				this.items[F * 2].setAttribute("y", (E + A) / 2 - 2)
			},
			modify : function() {
				var A = this.edge.innerPoints.length, $ = this.items.length;
				if (A * 2 + 1 > $) {
					this.items.push(this.createItem(0, 0, "middle:" + (A - 1) + "," + (A - 1)));
					this.items.push(this.createItem(0, 0, "middle:" + (A - 1) + "," + A))
				} else if (A * 2 + 1 < $) {
					var _ = null;
					_ = this.items[$ - 1];
					this.el.removeChild(_);
					this.items.remove(_);
					_ = this.items[$ - 2];
					this.el.removeChild(_);
					this.items.remove(_)
				}
				this.edge.refresh();
				this.update()
			}
		});
		Interface.figure.GraphicalViewport = Interface.extend(Interface.figure.GroupFigure, {
			LAYER_LANE : "LAYER_LANE",
			constructor : function($) {
				this.rootEditPart = $;
				this.rootFigure = new Interface.figure.RootFigure();
				this.layerMaps = {};
				this.init()
			},
			init : function() {
				var _ = new Interface.layer.GridLayer("LAYER_GRID");
				this.registerLayer(_);
				var D = new Interface.layer.Layer("LAYER_CONNECTION");
				this.registerLayer(D);
				var B = new Interface.layer.Layer("LAYER_NODE");
				this.registerLayer(B);
				var $ = new Interface.layer.Layer("LAYER_HANDLE");
				this.registerLayer($);
				var C = new Interface.layer.Layer("LAYER_DRAGGING");
				this.registerLayer(C);
				var A = new Interface.layer.Layer("LAYER_MASK");
				this.registerLayer(A)
			},
			registerLayer : function($) {
				this.addLayer($);
				this.layerMaps[$.getName()] = $
			},
			addLayer : function($) {
				this.rootFigure.addChild($)
			},
			getLayer : function($) {
				return this.layerMaps[$]
			},
			addNode : function($) {
				this.getLayer("LAYER_NODE").addChild($)
			},
			addConnection : function($) {
				this.getLayer("LAYER_CONNECTION").addChild($)
			},
			render : function() {
				if (this.rendered == true)
					return;
				this.rootFigure.setParent({
											  el : this.rootEditPart.getParentEl()
										  });
				this.rootFigure.render();
				this.rendered = true
			}
		});
		Interface.figure.TextEditor = function(A, _) {
			var $ = document.createElement("input");
			$.setAttribute("type", "text");
			$.value = "";
			$.style.position = "absolute";
			$.style.left = "0px";
			$.style.top = "0px";
			$.style.width = "0px";
			$.style.border = "gray dotted 1px";
			$.style.background = "white";
			$.style.display = "none";
			$.style.zIndex = 1000;
			$.style.fontFamily = "Verdana";
			$.style.fontSize = "12px";
			$.style.textAlign = "center";
			if(typeof Interface.parent != "undefined" && typeof Interface.ViewPort != "undefined"){
				Interface.ViewPort.appendChild($);
			}else
			{
				document.body.appendChild($);
			}
			this.el = $;
			this.baseX = A;
			this.baseY = _;
		};
		Interface.figure.TextEditor.prototype = {
			showForNode : function($) {
				this.el.style.left = (this.baseX + $.x + 5) + "px";
				this.el.style.top = (this.baseY + $.y + $.h / 2 - 12) + "px";
				this.el.style.width = ($.w - 10) + "px";
				this.el.value = $.name;
				this.el.style.display = "";
				this.el.focus();
			},
			showForEdge : function(_) {
				if (_ == null) return;//Jacky---------
				var A = _.getTextLocation(), D = A.x, C = A.y, $ = A.w, B = A.h;
				C -= B;
				this.el.style.left = this.baseX + D + "px";
				this.el.style.top = this.baseY + C + "px";
				this.el.style.width = $ + "px";
				this.el.value = _.name;
				this.el.style.display = "";
				this.el.focus()
			},
			getValue : function() {
				return this.el.value
			},
			hide : function() {
				this.el.style.display = "none"
			},
			show : function() {
				this.el.style.display = ""
			}
		};

		Interface.ns("Interface.layer");
		Interface.layer.Layer = Interface.extend(Interface.figure.GroupFigure, {
			LAYER_MASK : "LAYER_MASK",
			LAYER_LABEL : "LAYER_LABEL",
			LAYER_DRAGGING : "LAYER_DRAGGING",
			LAYER_HANDLE : "LAYER_HANDLE",
			LAYER_NODE : "LAYER_NODE",
			LAYER_CONNECTION : "LAYER_CONNECTION",
			LAYER_SNAP : "LAYER_SNAP",
			LAYER_GRID : "LAYER_GRID",
			constructor : function($) {
				this.name = $;
				this.id = $;
				Interface.layer.Layer.superclass.constructor.call(this)
			},
			getName : function() {
				return this.name
			}
		});
		Interface.layer.GridLayer = Interface.extend(Interface.layer.Layer, {});

	},
	//初始化图型界面接口
	initSimple : function(Interface) {
		Interface.ns("Interface.simple.figure");
		Interface.simple.figure.ProcessFigure = Interface.extend(Interface.figure.NoFigure, {});
		Interface.simple.figure.StartFigure = Interface.extend(Interface.figure.StartNodeFigure, {
			constructor : function($) {
				Interface.simple.figure.StartFigure.superclass.constructor.call(this, $);
			}
		});
		Interface.simple.figure.EndFigure = Interface.extend(Interface.figure.EndNodeFigure, {
			constructor : function($) {
				Interface.simple.figure.EndFigure.superclass.constructor.call(this, $);
			}
		});
		Interface.simple.figure.TaskFigure = Interface.extend(Interface.figure.NodeFigure, {});
		Interface.simple.figure.StateFigure = Interface.extend(Interface.figure.NodeFigure, {});
//合并
		Interface.simple.figure.JoinFigure = Interface.extend(Interface.figure.JoinNodeFigure, {
			constructor : function($) {
				Interface.simple.figure.JoinFigure.superclass.constructor.call(this, $);
			}
		});
		Interface.simple.figure.DecisionFigure = Interface.extend(Interface.figure.DecisionNodeFigure, {
			constructor : function($) {
				Interface.simple.figure.DecisionFigure.superclass.constructor.call(this, $);
			}
		});
//分散
		Interface.simple.figure.ForkFigure = Interface.extend(Interface.figure.ForkNodeFigure, {
			constructor : function($) {
				Interface.simple.figure.ForkFigure.superclass.constructor.call(this, $);
			}
		});
		Interface.simple.figure.CountersignFigure = Interface.extend(Interface.figure.SignNodeFigure , {
			constructor : function($) {
				Interface.simple.figure.CountersignFigure.superclass.constructor.call(this, $);
			}
		});
		Interface.simple.figure.SubprocessFigure = Interface.extend(Interface.figure.SubprocessNodeFigure , {
			constructor : function($) {
				Interface.simple.figure.SubprocessFigure.superclass.constructor.call(this, $);
			}
		});
		Interface.simple.figure.EndCancelFigure = Interface.extend(Interface.figure.CancelNodeFigure, {
			constructor : function($) {
				Interface.simple.figure.EndCancelFigure.superclass.constructor.call(this, $);
			}
		});
		Interface.simple.figure.TransitionFigure = Interface.extend(Interface.figure.EdInterfaceigure, {});
	},
	//初始化操作界面
	initPanel : function(Interface) {
		Interface.ns("Interface.simple");
		Interface.simple.SimpleEditPartFactory = Interface.extend(Interface.gef.EditPartFactory, {
			createEditPart : function($) {
				switch ($) {
					case "process" :
						return new Interface.simple.editpart.ProcessEditPart($);
					case "start" :
						return new Interface.simple.editpart.StartEditPart($);
					case "end" :
						return new Interface.simple.editpart.EndEditPart($);
					case "endCancel" ://新增的end-cancel节点
						return new Interface.simple.editpart.EndCancelEditPart($);
					case "task" :
						return new Interface.simple.editpart.TaskEditPart($);
					case "state" : //新增的节点
						return new Interface.simple.editpart.StateEditPart($);
					case "fork" : //新增的节点 : fork
						return new Interface.simple.editpart.ForkEditPart($);
					case "join" : //新增的节点 : join
						return new Interface.simple.editpart.JoinEditPart($);
					case "decision" : //新增的节点 : decision
						return new Interface.simple.editpart.DecisionEditPart($);
					case "transition" :
						return new Interface.simple.editpart.TransitionEditPart($);
					case "sign":
						return new Interface.simple.editpart.CountersignEditPart($);
					case "sub":
						return new Interface.simple.editpart.SubprocessEditPart($);
					default :
						return null
				}
			}
		});
		Interface.simple.SimpleModelFactory = Interface.extend(Interface.gef.ModelFactory, {
			getId : function($)
			{
				var editor          = Interface.activeEditor;
				var graphicalViewer = editor.getGraphicalViewer();
				var contents        = graphicalViewer.getContents();
				var elemnets        = contents.getModel().children;
				if (this.map == null || this.map == undefined)
				{
					var startNumber    = 0;
					var stateNumber    = 0;
					var taskNumber     = 0;
					var decisionNumber = 0;
					var forkNumber     = 0;
					var joinNumber     = 0;
					var endNumber      = 0;
					var subNumber	   = 0;
					var signNumber 	   = 0;
					var cancelNumber   = 0;
					for (var i = 0; i < elemnets.length; i++)
					{
						var element = elemnets[i];
						var type    = element.type;
						if ("start" == type)
						{
							startNumber++;
						}
						else if ("state" == type)
						{
							stateNumber++;
						}
						else if ("task" == type)
						{
							taskNumber++;
						}
						else if ("decision" == type)
						{
							decisionNumber++;
						}
						else if ("fork" == type)
						{
							forkNumber++;
						}
						else if ("join" == type)
						{
							joinNumber++;
						}
						else if ("end" == type)
						{
							endNumber++;
						}
						else if ("sub" == type)
						{
							subNumber++;
						}
						else if ("sign" == type)
						{
							signNumber++;
						}else if ("endCancel" == type)
						{
							cancelNumber++;
						}
					}
					this.map             = {};
					this.map['start']    = startNumber;
					this.map['state']    = stateNumber;
					this.map['task']     = taskNumber;
					this.map['decision'] = decisionNumber;
					this.map['fork']     = forkNumber;
					this.map['join']     = joinNumber;
					this.map['end']      = endNumber;
					this.map['sub']		 = subNumber;
					this.map['sign']	 = signNumber;
					this.map['endCancel'] = cancelNumber;
				}

				if ($ == "transition")
				{
					if (this.map[$] == null || this.map[$] == undefined)
						this.map[$] = 1;
					else
						this.map[$]++;
					return $ + "_" + this.map[$];
				}
				else
				{
					if (this.map[$] == null || this.map[$] == undefined)
						this.map[$] = 1;
					else
					{
						if (this.map[$] <= elemnets.length)
							this.map[$]++;
					}

					for (var i = 1; i <= this.map[$]; i++)
					{
						var tmp    = $ + "_" + i;
						var isfind = false;
						for (var j = 0; j < elemnets.length; j++)
						{
							if (elemnets[j].text == tmp)
							{
								isfind = true;
								break;
							}
						}
						if (!isfind)
						{
							return tmp;
						}
					}
				}
			},
			reset : function() {
				delete this.map;
				this.map = {}
			},
			createModel : function(_) {
				var $ = this.getId(_);
				switch (_) {
					case "process" :
						return new Interface.simple.model.ProcessModel({
																		   id : $,
																		   text : $
																	   });
					case "start" :
						return new Interface.simple.model.StartModel({
																		 id : $,
																		 text : "开始"
																	 });
					case "state" :
						return new Interface.simple.model.StateModel({
																		 id : $,
																		 text : $
																	 });
					case "fork" : //fork
						return new Interface.simple.model.ForkModel({
																		id : $,
																		text : $
																	});
					case "join" :
						return new Interface.simple.model.JoinModel({
																		id : $,
																		text : $
																	});
					case "decision" :
						return new Interface.simple.model.DecisionModel({
																			id : $,
																			text : $
																		});
					case "end" :
						return new Interface.simple.model.EndModel({
																	   id : $,
																	   text : "结束"
																   });
					case "endCancel" :
						return new Interface.simple.model.EndCancelModel({
																			 id : $,
																			 text : "中止"
																		 });
					case "task" :
						return new Interface.simple.model.TaskModel({
																		id : $,
																		text : $
																	});
					case "transition" :
						return new Interface.simple.model.TransitionModel({
																			  id : $,
																			  text : $
																		  });
					case "sign":
						return new Interface.simple.model.CountersignModel({
																			   id : $,
																			   text : $
																		   });
					case "sub":
						return new Interface.simple.model.SubprocessModel({
																			  id : $,
																			  text : $
																		  });
					default :
						return null
				}
			}
		});
		Interface.simple.SimplePaletteHelper = Interface.extend(Interface.gef.support.PaletteHelper, {
			constructor : function($) {
				this.editor = $
			},
			createSource : function() {
				var $ = this;
				return {
					title : "palette",
					buttons : [{
						text : "export",
						handler : function() {
							alert($.editor.serial())
						}
					}, {
						text : "clear",
						handler : function() {
							$.editor.clear()
						}
					}, {
						text : "reset",
						handler : function() {
							$.editor.reset()
						}
					}],
					groups : [{
						title : "Operations",
						items : [{
							text : "Select",
							iconCls : "Interface-tool-select",
							creatable : false
						}, {
							text : "Marquee",
							iconCls : "Interface-tool-marquee",
							creatable : false
						}]
					}, {
						title : "Activities",
						items : [{
							text : "transition",
							iconCls : "Interface-tool-transition",
							creatable : false,
							isConnection : true
						}, {
							text : "start",
							iconCls : "Interface-tool-start",
							w : 48,
							h : 48
						}, {
							text : "state",
							iconCls : "Interface-tool-state",
							w : 90,
							h : 50
						}, {
							text : "join",
							iconCls : "Interface-tool-join",
							w : 48,
							h : 48
						},{
							text : "fork",
							iconCls : "Interface-tool-fork",
							w : 48,
							h : 48
						}, {
							text : "decision",
							iconCls : "Interface-tool-decision",
							w : 48,
							h : 48
						}, {
							text : "end",
							iconCls : "Interface-tool-end",
							w : 48,
							h : 48
						}, {
							text : "endCancel",
							iconCls : "Interface-tool-end-cancel",
							w : 48,
							h : 48
						}, {
							text : "task",
							iconCls : "Interface-tool-task",
							w : 90,
							h : 50
						},{
							text : "sign",
							iconCls : "Interface-tool-fork",
							w : 90,
							h : 50
						},{
							text : "sub",
							iconCls : "Interface-tool-fork",
							w : 90,
							h : 50
						}]
					}]
				}
			},
			getSource : function() {
				if (!this.source)
					this.source = this.createSource();
				return this.source
			},
			render : function(O) {
				var C = this.getSource(), K = document.createElement("div");
				K.className = "Interface-drag-handle";
				O.appendChild(K);
				var $ = document.createElement("span");
				K.appendChild($);
				$.unselectable = "on";
				$.innerHTML = C.title;
				var L = this;
				for (var F = 0; F < C.buttons.length; F++) {
					var I = C.buttons[F], _ = document.createElement("a");
					_.href = "javascript:void(0);";
					_.onclick = I.handler;
					_.innerHTML = "|" + I.text + "|";
					$.appendChild(_)
				}
				var A = document.createElement("ul");
				O.appendChild(A);
				for (F = 0; F < C.groups.length; F++) {
					var M = C.groups[F], D = document.createElement("li");
					D.className = "Interface-palette-bar";
					A.appendChild(D);
					var H = document.createElement("div");
					H.unselectable = "on";
					H.innerHTML = M.title;
					D.appendChild(H);
					var N = document.createElement("ul");
					D.appendChild(N);
					for (var E = 0; E < M.items.length; E++) {
						var J = M.items[E], G = document.createElement("li");
						G.id = J.text;
						G.className = "Interface-palette-item";
						N.appendChild(G);
						var B = document.createElement("span");
						B.innerHTML = J.text;
						B.className = J.iconCls;
						B.unselectable = "on";
						G.appendChild(B)
					}
				}
			},
			getActivePalette : function() {
				return this.activePalette
			},
			setActivePalette : function($) {
				this.activePalette = $
			},
			getPaletteConfig : function(D, _) {
				var $ = _.parentNode.id;
				if (!$)
					return null;
				var B = this.getSource(), E = null;
				Interface.each(B.groups, function(_) {
					Interface.each(_.items, function(_) {
						if (_.text == $) {
							E = _;
							return false
						}
					});
					if (E != null)
						return false
				});
				if (!E)
					return null;
				var A = null;
				if (this.getActivePalette()) {
					var C = this.getActivePalette().text;
					A = document.getElementById(C);
					A.style.background = "white"
				}
				this.setActivePalette(E);
				A = document.getElementById($);
				A.style.background = "#CCCCCC";
				if (E.creatable == false)
					return null;
				return E
			}
		});
		Interface.simple.SimpleEditor = Interface.extend(Interface.gef.support.DefaultGraphicalEditorWithPalette, {
			constructor : function() {
				this.modelFactory = new Interface.simple.SimpleModelFactory();
				this.editPartFactory = new Interface.simple.SimpleEditPartFactory();
				Interface.simple.SimpleEditor.superclass.constructor.call(this)
			},
			getPaletteHelper : function() {
				if (!this.paletteHelper)
					this.paletteHelper = new Interface.simple.SimplePaletteHelper(this);
				return this.paletteHelper
			},
			serial : function() {
				var $ = this.getGraphicalViewer().getContents().getModel(),
					_ = new Interface.simple.xml.SimpleSerializer($),
					A = _.serialize();
				return A
			},
			//逆向生成流程图的方法
			deserial : function() {
			},

			clear : function() {
				var D = this.getGraphicalViewer(), C = D.getContents(),
					B = D.getBrowserListener(),
					_ = D.getEditDomain().getCommandStack(),
					$ = B.getSelectionManager();
				$.selectAll();
				var A = C.getRemoveNodesCommand({
													role : {
														nodes : $.getSelectedNodes()
													}
												});
				_.execute(A);
				$.clearAll();
				this.editDomain.editPartRegistry = []
			},
			reset : function() {
				this.clear();
				var A = this.getGraphicalViewer(), $ = A.getEditDomain().getCommandStack();
				$.flush();
				this.getModelFactory().reset();
				var _ = A.getContents();
				_.text = "untitled";
				_.key = null;
				_.description = null
			},
		});
		Interface.simple.SimpleEditorInput = Interface.extend(Interface.ui.EditorInput, {
			constructor : function($) {
				if (!$)
					$ = "process";
				this.simpleModel = $
			},
			readXml : function($) {
				var _ = new Interface.simple.xml.SimpleDeserializer($);
				this.simpleModel = _.decode()
			},
			getName : function() {
				return this.simpleModel.name
			},
			getObject : function() {
				return this.simpleModel
			}
		});
		Interface.simple.ExtEditor = Interface.extend(Interface.simple.SimpleEditor, {
			createGraphicalViewer : function() {
				return new Interface.simple.ExtGraphicalViewer(this)
			},
			getPaletteHelper : function() {
				if (!this.paletteHelper)
					this.paletteHelper = new Interface.simple.ExtPaletteHelper(this);
				return this.paletteHelper
			},
			addSelectionListener : function($) {
				var _ = this.getGraphicalViewer().getBrowserListener().trackers;
				_[_.length - 1].addSelectionListener($)
			}
		});
		Interface.simple.ExtGraphicalViewer = Interface.extend(Interface.gef.support.DefaultGraphicalViewer, {
			render : function() {
				var DomID = "_" + Interface.parentid + "_center_";
				this.canvasEl = Interface.EditorPanelClass.getDom(DomID);
				this.rootEditPart.render()
			},
			getPaletteLocation : function() {
				var DomID = "_" + Interface.parentid + "_palette_";
				var Palette = Interface.EditorPanelClass.get(DomID);
				if(Palette){
					var $ = Palette.getBox();
					return {
						x: $.x,
						y: $.y,
						w: $.width,
						h: $.height
					}
				}else{
					return {
						x: 0,
						y: 0,
						w: 0,
						h: 0
					}
				}
			},
			getCanvasLocation : function() {
				var DomID = "_" + Interface.parentid + "_center_";
				var Canvas = Interface.EditorPanelClass.get(DomID);
				if(Canvas){
					var _ = Canvas.getBox();
					return {
						x : _.x,
						y : _.y,
						w : _.width,
						h : _.height
					};
				}else{
					return {
						x: 0,
						y: 0,
						w: 0,
						h: 0
					}
				}
			},
			getCanvasClientLocation : function(){
				var DomID = "_" + Interface.parentid + "_";
				var CanvasClient = Interface.EditorPanelClass.get(DomID);
				if(CanvasClient)
				{
					var _ = CanvasClient.getBox();
					var $ = Interface.EditorPanelClass.getDom(DomID).parentNode;
					return {
						x: _.x,
						y: _.y,
						w: _.width,
						h: _.height,
						cw: $.clientWidth,
						ch: $.clientHeight,
						st: $.scrollTop,
						sl: $.scrollLeft,
						srw: ($.offsetWidth - $.clientWidth > 0) ? $.offsetWidth - $.clientWidth : 0,
						sbw: ($.offsetHeight - $.clientHeight > 0) ? $.offsetHeight - $.clientHeight : 0
					};
				}else{
					return {
						x: 0,
						y: 0,
						w: 0,
						h: 0,
						cw: 0,
						ch: 0,
						st: 0,
						sl: 0,
						sw: 0
					};
				}
			}
		});
		Interface.simple.ExtPaletteHelper = Interface.extend(Interface.simple.SimplePaletteHelper, {
			createSource : function() {
				return {
					select : {
						text : "select",
						image : "select",
						creatable : false
					},
					transition : {
						text : "transition",
						image : "transition",
						creatable : false,
						isConnection : true
					},
					start : {
						text : "start",
						image : "start",
						w : 48,
						h : 48
					},
					end : {
						text : "end",
						image : "end",
						w : 48,
						h : 48
					},
					endCancel : {
						text : "endCancel",
						image : "endCancel",
						w : 48,
						h : 48
					},
					task : {
						text : "task",
						image : "task",
						w : 90,
						h : 50
					},
					state : {
						text : "state",
						image : "state",
						w : 90,
						h : 50
					},
					fork : {
						text : "fork",
						image : "fork",
						w : 100,
						h : 60
					},
					join : {
						text : "join",
						image : "join",
						w : 100,
						h : 60
					},
					decision : {
						text : "decision",
						image : "decision",
						w : 100,
						h : 60
					},
					sign : {
						text : "sign",
						image : "sign",
						w : 100,
						h : 60
					},
					sub : {
						text : "sub",
						image : "sub",
						w : 100,
						h : 60
					}
				}
			},
			getSource : function() {
				if (!this.source)
					this.source = this.createSource();
				return this.source
			},
			render : Interface.emptyFn,
			getPaletteConfig : function(D, _) {
				var $ = _.parentNode.id;
				if (!$)
					return null;
				var B = this.getSource(), E = B[$];
				if (!E)
					return null;
				var A = null;
				if (this.getActivePalette()) {
					var C = this.getActivePalette().text;
					var I = this.getActivePalette().image;
					A = document.getElementById(C + "-img");
					A.setAttribute("src",Interface.IMAGE_ROOT + I + ".png");
					// A.style.border = ""
					A.style.backgroundColor = "transparent";
				}
				this.setActivePalette(E);
				A = document.getElementById($ + "-img");
				A.setAttribute("src",Interface.IMAGE_ROOT + E.image + "-s.png");
				A.style.backgroundColor = "#b8b8b8";
				// A.style.border = "1px dotted black";color="#b8b8b8"
				if (E.creatable == false)
					return null;
				return E
			}
		});
		Interface.simple.ExtSelectionListener = Interface.extend(Interface.gef.tracker.DefaultSelectionListener, {
			constructor : function($) {
				this.propertyGrid = $
			},
			selectNode : function(_) {
				var $ = _.getModel();
				if (this.propertyGrid)
					this.propertyGrid.updateForm($);
				this.model = $
			},
			selectConnection : function(_) {
				var $ = _.getModel();
				if (this.propertyGrid)
					this.propertyGrid.updateForm($);
				this.model = $
			},
			selectDefault : function(_) {
				var $ = _.getModel();
				if (this.propertyGrid)
					this.propertyGrid.updateForm($);
				this.model = $
			},
			setEditor : function($) {
				this.editor = $;
				this.model = $.getGraphicalViewer().getContents().getModel()
			},
			editText : function(_, $) {
				var A = new Interface.gef.command.EditTextCommand(_, $);
				this.editor.getEditDomain().getCommandStack().execute(A)
			},
			getModel : function() {
				return this.model
			}
		});
	},
	//初始化编辑器流程信息接口
	initEditorPara : function(Interface) {
		Interface.ns("Interface.Editor");
		Interface.Editor = {
			ShowMode : Interface.ShowMode.MODE_EDIT,
			createWest : function() {
				var $ = new Interface.Editor.PalettePanel({
															  collapsible : false
														  });
				Interface.Editor.westPanel = $;
				return $
			},
			createCenter : function() {
				var $ = new Interface.Editor.CanvasPanel();
				Interface.Editor.centerPanel = $;
				return $
			},
			CanvasPanel : Interface.EditorPanelClass.extend(Interface.EditorPanelClass.Panel, {
				initComponent : function() {
					this.region = "center";
					this.autoScroll = true;
					this.cls = 'left_ext top_ext';
					if(Interface.Editor.ShowMode == Interface.ShowMode.MODE_EDIT)
					{
						this.tbar = new Interface.EditorPanelClass.Toolbar([
							{
							text: "清空",
							iconCls: "tb-clear",
							handler: function ()
							{
								if (typeof Interface.activeEditor != "undefined")
								{
									var B = Interface.activeEditor.getGraphicalViewer(),
										A = B.getBrowserListener(),
										$ = A.getSelectionManager();
									$.selectAll();
									Interface.Editor.centerPanel.removeSelected();
								}
							}
						},
					     {
							text: "撤销",
							iconCls: "tb-undo",
							handler: function ()
							{
								if (typeof Interface.activeEditor != "undefined")
								{
									var B = Interface.activeEditor.getGraphicalViewer(),
										A = B.getBrowserListener(),
										$ = A.getSelectionManager();
									$.clearAll();
									var _ = B.getEditDomain().getCommandStack();
									_.undo()
								}
							},
							scope: this
						}, {
							text: "重做",
							iconCls: "tb-redo",
							handler: function ()
							{
								if (typeof Interface.activeEditor != "undefined")
								{
									var B = Interface.activeEditor.getGraphicalViewer(),
										A = B.getBrowserListener(),
										$ = A.getSelectionManager();
									$.clearAll();
									var _ = B.getEditDomain().getCommandStack();
									_.redo()
								}
							},
							scope: this
						}]);
					}
					Interface.Editor.CanvasPanel.superclass.initComponent.call(this)
				},
				afterRender : function() {
					var tbarH = 0;
					if(this.tbar){
						tbarH = Interface.EditorPanelClass.fly(this.tbar.id).getHeight();
					}
					var westW = 0;
					if(Interface.Editor.westPanel){
						westW = Interface.EditorPanelClass.fly(Interface.Editor.westPanel.id).getWidth();
					}
					var view_width = Interface.parent.offsetWidth - 5;
					var view_height = Interface.parent.offsetHeight - 5;
					if(Interface.Editor.ShowMode == Interface.ShowMode.MODE_EDIT) {
						view_width -= westW;
						view_height -= tbarH;
					}
					var center_width = view_width - 10;
					var center_height = view_height - 10;

					Interface.Editor.CanvasPanel.superclass.afterRender.call(this);

					var DomID = "__gef_simple__", DomCID = "__gef_simple_center__", DomBID = "__gef_simple_bottom__", DomRID = "__gef_simple_right__";
					if(Interface.parentid != "" && Interface.parentid != null){
						DomID = "_" + Interface.parentid + "_";
						DomCID = "_" + Interface.parentid + "_center_";
						DomBID = "_" + Interface.parentid + "_bottom_";
						DomRID = "_" + Interface.parentid + "_right_";
					}
					var CenterPanel = {
						id : DomCID,//中间的流程图绘制区域
						tag : "div",
						style : "width:"+center_width+"px;height:"+center_height+"px;float:left;"
					};
					var RightPanel = {
						id : DomRID,//SVG右边界
						tag : "div",
						style : "width:10px;height:"+(center_height)+"px;float:left;background-color:#EEEEEE;cursor:pointer;"
					};
					var BottomPanel = {
						id : DomBID,//SVG底部边界
						tag : "div",
						style : "width:"+center_width+"px;height:10px;float:left;background-color:#EEEEEE;cursor:pointer;"
					};

					var Children = [CenterPanel,RightPanel,BottomPanel];
					Interface.EditorPanelClass.DomHelper.append(this.body, [{
						id : DomID,
						tag : "div",
						style : "width:"+view_width+"px;height:"+view_height+"px;",
						children : Children
					}]);
					var $ = Interface.EditorPanelClass.fly(DomBID);
					if($)
					{
						$.on("mouseover", function (_)
						{
							var $                   = _.getTarget();
							$.style.backgroundColor = "yellow";
							$.style.backgroundImage = "url(" + Interface.IMAGE_ROOT + "/arrow-bottom.png)"
						});
						$.on("mouseout", function (_)
						{
							var $                   = _.getTarget();
							$.style.backgroundColor = "#EEEEEE";
							$.style.backgroundImage = ""
						});
						$.on("click", function ($)
						{
							Interface.EditorPanelClass.fly(DomID).setHeight(Interface.EditorPanelClass.fly(DomID).getHeight() + 100);
							Interface.EditorPanelClass.fly(DomCID).setHeight(Interface.EditorPanelClass.fly(DomCID).getHeight() + 100);
							Interface.EditorPanelClass.fly(DomRID).setHeight(Interface.EditorPanelClass.fly(DomRID).getHeight() + 100);
							var parent = Interface.EditorPanelClass.fly(DomID).parent('div',true);
							var scrollW = parent.scrollWidth - parent.clientWidth;
							var scrollH = parent.scrollHeight - parent.clientHeight;
							if(scrollW < 50){
								Interface.EditorPanelClass.fly(DomID).setWidth(parent.clientWidth);
								Interface.EditorPanelClass.fly(DomBID).setWidth(parent.clientWidth-10);
								Interface.EditorPanelClass.fly(DomCID).setWidth(parent.clientWidth-10);
							}
							if (typeof Interface.activeEditor != "undefined")
							{
								Interface.activeEditor.addHeight(100)
								if(scrollW < 50){
									Interface.activeEditor.setWidth(parent.clientWidth-10)
								}
							}
							parent.scrollTop = scrollH;
						});
					}
					var _ = Interface.EditorPanelClass.fly(DomRID);
					if(_){
						_.on("mouseover", function(_) {
							var $ = _.getTarget();
							$.style.backgroundColor = "yellow";
							$.style.backgroundImage = "url("+Interface.IMAGE_ROOT+"/arrow-right.png)"
						});
						_.on("mouseout", function(_) {
							var $ = _.getTarget();
							$.style.backgroundColor = "#EEEEEE";
							$.style.backgroundImage = ""
						});
						_.on("click", function($) {
							Interface.EditorPanelClass.fly(DomID).setWidth(Interface.EditorPanelClass.fly(DomID).getWidth() + 100);
							Interface.EditorPanelClass.fly(DomCID).setWidth(Interface.EditorPanelClass.fly(DomCID).getWidth() + 100);
							Interface.EditorPanelClass.fly(DomBID).setWidth(Interface.EditorPanelClass.fly(DomBID).getWidth() + 100);
							var parent = Interface.EditorPanelClass.fly(DomID).parent('div',true);
							var scrollH = parent.scrollHeight - parent.clientHeight;
							var scrollW = parent.scrollWidth - parent.clientWidth;
							if(scrollH < 50){
								Interface.EditorPanelClass.fly(DomID).setHeight(parent.clientHeight);
								Interface.EditorPanelClass.fly(DomRID).setHeight(parent.clientHeight-10);
								Interface.EditorPanelClass.fly(DomCID).setHeight(parent.clientHeight-10);
							}
							if (typeof Interface.activeEditor != "undefined")
							{
								Interface.activeEditor.addWidth(100)
								if(scrollH < 50){
									Interface.activeEditor.setHeight(parent.clientHeight-10)
								}
							}
							parent.scrollLeft = scrollW;
						});
					}
					this.body.on("contextmenu", this.onContextMenu, this)
				},
				onContextMenu : function($) {
					this.contextMenu = this.createRightMenu();
					$.preventDefault();
					if(null != this.contextMenu)
						this.contextMenu.showAt($.getXY())
				},
				createRightMenu : function(){
					if (typeof Interface.activeEditor != "undefined")
					{
						var graphicalViewer    = Interface.activeEditor.getGraphicalViewer();
						var bsListener         = graphicalViewer.getBrowserListener();
						var selectionManager   = bsListener.getSelectionManager();
						var selectedConnection = selectionManager.selectedConnection;
						var selectedNodes      = selectionManager.items;
						var menuItems          = new Array();
						var screenMenu         = {
							text: '基本设置',
							iconCls: "tb-prop",
							handler: this.setScreen,
							scope: this
						}
						var permissionMenu     = {
							text: '权限设置',
							iconCls: "tb-prop",
							handler: this.setPermission,
							scope: this
						}
						var taskMenu           = {
							text: '任务设置',
							iconCls: "tb-prop",
							handler: this.setTask,
							scope: this
						}
						var timerMenu          = {
							text: '定时器设置',
							iconCls: "tb-prop",
							handler: this.setTimer,
							scope: this
						}
						var joinMenu           = {
							text: '汇聚条件设置',
							iconCls: "tb-prop",
							handler: this.setJoin,
							scope: this
						}
						var signMenu           = {
							text: '会签设置',
							iconCls: 'tb-prop',
							handler: this.setSign,
							scope: this
						}
						var trendMenu          = {
							text: '流转设置',
							iconCls: "tb-prop",
							handler: this.setTrend,
							scope: this
						}
						var RotateMenu         = {
							text: '旋转',
							iconCls: 'tb-prop',
							handler: this.setRotate,
							scope: this
						}
						var viewSubProcessMenu = {
							text: '查看子流程',
							iconCls: "tb-prop",
							handler: this.viewSubProcess,
							scope: this
						}
						var subProcessMenu     = {
							text: '设置子流程',
							iconCls: "tb-prop",
							handler: this.setSubProcess,
							scope: this
						}
						var deleteMenu         = {
							text: '删除',
							iconCls: "tb-remove",
							handler: this.removeSelected,
							scope: this
						}
						var separatorMenu      = "-"
						if (null != selectedConnection)
						{//选择了边
							var srcNode = selectedConnection.source;
							var type    = srcNode.model.type;
							if ('start' != type)
							{//开始节点的出边上不允许设置screen（ISM-8303）
								menuItems.push(screenMenu);
								menuItems.push(separatorMenu);
							}
							menuItems.push(deleteMenu);
						}
						else if (null != selectedNodes)
						{//选择了节点
							if (selectedNodes.length == 1)
							{//只选择一个节点
								var node = selectedNodes[0];
								var type = node.model.type;
								if ('start' == type)
								{
									menuItems.push(screenMenu);
									menuItems.push(permissionMenu);
									// menuItems.push(timerMenu);
								}
								if ('join' == type)
								{//合并节点，需设置汇聚条件
									menuItems.push(joinMenu);
								}
								if ('sign' == type)
								{//会签节点，设置会签节点的属性
									menuItems.push(signMenu);
								}
								if ('state' == type || 'task' == type)
								{//手动节点，需要设置权限和Screen
									menuItems.push(screenMenu);
									if ('task' == type)
									{
										menuItems.push(permissionMenu);
										// menuItems.push(taskMenu);
										// menuItems.push(separatorMenu);
									}
									// menuItems.push(timerMenu);
								}
								else if ('decision' == type)
								{//判断节点，需要设置逻辑判断条件
									menuItems.push(trendMenu);
									menuItems.push(RotateMenu);
								}
								else if ('sub' == type)
								{ //子流程设置
									menuItems.push(viewSubProcessMenu);
									menuItems.push(subProcessMenu);
								}
								if ('start' != type)
								{
									if(menuItems.length > 0)
									{
										menuItems.push(separatorMenu);
									}
									menuItems.push(deleteMenu);
								}
							}
							else if (selectedNodes.length > 0)
							{//选择了多个节点
								menuItems.push(deleteMenu);
							}
						}
						if (0 == menuItems.length)
						{
							return null;
						}
						else
						{
							var contextMenu = new Interface.EditorPanelClass.menu.Menu({
																	parentEl: Interface.ViewPort,
																	items: menuItems
																});
							if (graphicalViewer.contextmenu != null)
							{
								graphicalViewer.contextmenu.destroy();
							}
							graphicalViewer.contextmenu = contextMenu;
							return contextMenu;
						}
					}
				},
				setScreen : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedConnection = selectionManager.selectedConnection;
					if(null != selectedConnection){//设置边上的Screen
						var srcNode = selectedConnection.source;
						Interface.Event.trigger(Interface.EventMode.DialogScreenTransition,"【"+selectedConnection.model.text+"】边基本设置",srcNode.model.key,selectedConnection.model.text);
					}else{//设置节点上的Screen
						var selectedNodes = selectionManager.items;
						var selectedNode = selectedNodes[0];
						Interface.Event.trigger(Interface.EventMode.DialogScreenNode,"【"+selectedNode.model.text+"】节点基本设置",selectedNode.model.key);
					}
				},
				setPermission : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					// var type = selectedNode.model.type;
					// var nodeName = selectedNode.model.text;
					var transitionNames = new Array();
					var transitions = selectedNode.model.sourceConnections;
					for(var i=0;i<transitions.length;i++){
						transitionNames.push(transitions[i].text);
					}
					Interface.Event.trigger(Interface.EventMode.DialogPermission,"【"+selectedNode.model.text+"】节点权限设置",selectedNode.model.key,transitionNames);
				},
				setTrend : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					// var nodeName = selectedNode.figure.name;
					var transitionNames = new Array();
					var transitions = selectedNode.model.sourceConnections;
					if(null == transitions || transitions.length==0){
						Interface.Event.trigger(Interface.EventMode.Info,"请先设置判断节点的出边！")
						return;
					}
					for(var i=0;i<transitions.length;i++){
						transitionNames.push(transitions[i].text);
					}
					Interface.Event.trigger(Interface.EventMode.DialogTrend,"【"+selectedNode.figure.name+"】节点设定分支条件",selectedNode.figure.key,transitionNames);
				},
				setRotate : function() {
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					if(selectedNode.figure.rotate > 2){
						selectedNode.figure.setRotate(0);
					}else{
						selectedNode.figure.setRotate(++selectedNode.figure.rotate);
					}
				},
				setTimer : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					// var nodeName = selectedNode.model.text;
					var transitionNames = new Array();
					var transitions = selectedNode.model.sourceConnections;
					if(null == transitions || transitions.length==0){
						Interface.Event.trigger(Interface.EventMode.Info,"请先设置任务节点的出边！")
						return;
					}
					for(var i=0;i<transitions.length;i++){
						transitionNames.push(transitions[i].editPart.figure.name);
					}
					Interface.Event.trigger(Interface.EventMode.DialogTimer,"【"+selectedNode.model.text+"】节点定时器设置",selectedNode.model.key,transitionNames);
				},
				setTask : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					// var nodeName = selectedNode.model.text;
					Interface.Event.trigger(Interface.EventMode.DialogTask,"【"+selectedNode.model.text+"】节点任务设置",selectedNode.model.key);
				},
				setJoin : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					// var nodeName = selectedNode.model.text;
					var transitionNames = new Array();
					var transitions = selectedNode.model.targetConnections;
					for(var i=0;i<transitions.length;i++){
						transitionNames.push(transitions[i].text);
					}
					Interface.Event.trigger(Interface.EventMode.DialogJoin,"【"+selectedNode.model.text+"】节点汇聚条件设置",selectedNode.model.key,transitionNames);
				},
				setSign : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					// var nodeName = selectedNode.model.text;
					var transitionNames = new Array();
					var transitions = selectedNode.model.sourceConnections;
					if(null == transitions || transitions.length!=2){
						Interface.Event.trigger(Interface.EventMode.Info,"请先为会签节点设置代表通过与否决的两条出边！")
						return;
					}
					for(var i=0;i<transitions.length;i++){
						transitionNames.push(transitions[i].text);
					}
					Interface.Event.trigger(Interface.EventMode.DialogSign,"【"+selectedNode.model.text+"】节点会签属性设置",selectedNode.model.key,transitionNames);
				},
				setSubProcess : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					// var nodeName = selectedNode.model.key;
					var transitions = selectedNode.model.targetConnections;
					if(null == transitions || transitions.length==0){
						Interface.Event.trigger(Interface.EventMode.Info,"请先设置子流程节点的入边！")
						return;
					}
					Interface.Event.trigger(Interface.EventMode.DialogSubProcess,"【"+selectedNode.model.text+"】节点设置子流程",selectedNode.model.key);
				},
				viewSubProcess : function(){
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer();
					var bsListener = graphicalViewer.getBrowserListener();
					var selectionManager = bsListener.getSelectionManager();
					var selectedNodes = selectionManager.items;
					var selectedNode = selectedNodes[0];
					// var nodeName = selectedNode.model.key;
					Interface.Event.trigger(Interface.EventMode.DialogViewSubProcess,'【'+selectedNode.model.text+'】节点查看子流程',selectedNode.model.key)
				},
				showWindow : function() {
					if (!this.propertyWindow)
						this.propertyWindow = new Interface.Editor.form.PropertyWindow({
																						   closeAction : "hide"
																					   });
					this.propertyWindow.show()
				},
				removeSelected : function() {
					var graphicalViewer = Interface.activeEditor.getGraphicalViewer(),
						C = graphicalViewer.getBrowserListener(),
						$ = C.getSelectionManager(),
						_ = $.selectedConnection, A = $.items, B = {};
					if (_ != null) {//删除边
						B.role = {
							name : "REMOVE_EDGE"
						};
						var srcNodeName = _.source.model.key;
						var tagNodename = _.target.model.key;
						var transitionName = _.model.text;
						this.executeCommand(_, B);
						$.removeSelectedConnection();
						Interface.Event.trigger(Interface.EventMode.RemoveTransition,srcNodeName,tagNodename,transitionName);
					} else if (A.length > 0) {//删除节点
						B.role = {
							name : "REMOVE_NODES",
							nodes : A
						};
						var selectedNodes = {};
						for(var j=0; j < A.length; j++){
							var selectedNode = A[j];
							var nodeName = selectedNode.model.key;
							var outTransitions = selectedNode.model.sourceConnections;
							var outTransitionNames = [];
							if(null != outTransitions && outTransitions.length>0){
								for(var i=0;i<outTransitions.length;i++){
									outTransitionNames.push(outTransitions[i].text);
								}
							}
							var inTransitions = selectedNode.model.targetConnections;
							var inTransitionNames = [];
							var previousNodeName = [];
							if(null != inTransitions && inTransitions.length>0){
								for(var i=0;i<inTransitions.length;i++){
									inTransitionNames.push(inTransitions[i].key);
									previousNodeName.push(inTransitions[i].source.key)
								}
							}
							selectedNodes[nodeName] = {};
							if(previousNodeName.length > 0){
								selectedNodes[nodeName]["previousNodeName"] = previousNodeName;
							}else{
								selectedNodes[nodeName]["previousNodeName"] = "";
							}
							if(outTransitionNames.length > 0){
								selectedNodes[nodeName]["outTransitionNames"] = outTransitionNames;
							}else{
								selectedNodes[nodeName]["outTransitionNames"] = "";
							}
							if(inTransitionNames.length > 0){
								selectedNodes[nodeName]["inTransitionNames"] = inTransitionNames;
							}else{
								selectedNodes[nodeName]["inTransitionNames"] = "";
							}
						}
						this.executeCommand(graphicalViewer.getContents(), B);
						$.clearAll();
						Interface.Event.trigger(Interface.EventMode.RemoveNode,selectedNodes);
					}
				},
				executeCommand : function(A, $) {
					var _ = A.getCommand($);
					if (_ != null)
						Interface.activeEditor.getGraphicalViewer().getEditDomain().getCommandStack().execute(_)
				}
			}),
			PalettePanel: Interface.EditorPanelClass.extend(Interface.EditorPanelClass.Panel, {
				initComponent : function() {
					this.region     = "west";
					this.title      = "活动组件";
					this.iconCls    = "tb-activity";
					this.border     = true;
					this.cls        = 'top_ext';
					this.width      = 110;
					this.height     = 500;
					this.autoScroll = true;
					this.createHtml([{
						name: "select",
						image: "select",
						title: "选择"
					}, {
						name: "transition",
						image: "transition",
						title: "连线"
					}, {
						name: "start",
						image: "start",
						title: "开始"
					},
					{
						name: "task",
						image: "task",
						title: "任务"
					}, {
						name: "sign",
						image: "sign",
						title: "会签"
					}, {
						name: "sub",
						image: "sub",
						title: "子流程"
					}, {
						name: "decision",  //decision
						image: "decision",
						title: "判断"
					}, {
						name: "fork",  //fork
						image: "fork",
						title: "分支"
					}, {
						name: "join", //join
						image: "join",
						title: "合并"
					}, {
						name: "end",
						image: "end",
						title: "结束"
					}, {
						name: "endCancel",
						image: "endCancel",
						title: "中止"
					}]);
					Interface.Editor.PalettePanel.superclass.initComponent.call(this)
				},
				createHtml : function(C) {
					var DomID = "__gef_simple_palette__";
					if(Interface.parentid != "" && Interface.parentid != null){
						DomID = "_" + Interface.parentid + "_palette_"
					}
					var A = Interface.IMAGE_ROOT, _ = "<div id=\"" + DomID + "\" unselectable=\"on\">";
					for (var B = 0; B < C.length; B++) {
						var $ = C[B];
						_ += "<div id=\"" + $.name + "\" class=\"paletteItem-" + $.name
							 + "\" style=\"text-align:center;font-size:12px;cursor:pointer;padding: 4px 0px 2px 0px;\" unselectable=\"on\"><img id=\""
							 + $.name + "-img\" class=\"paletteItem-" + $.name + "\" src=\"" + A + $.image
							 + ".png\" unselectable=\"on\"><br>" + $.title + "</div>"
					}
					_ += "</div>";
					this.html = _
				}
			}),
			ValidateFlow : function() {
				var editor = Interface.activeEditor;
				var model = editor.getGraphicalViewer().getContents().getModel();
				var totalNodes = model.getChildren();
				if(totalNodes.length <= 0){
					return true;
				}
				var isStart = false, isEnd = false, isSub = false, nextNode = null;
				for(i=0;i<totalNodes.length;i++){
					if(totalNodes[i].type == "start")
					{
						isStart = true;
						nextNode = totalNodes[i];
					}else if(totalNodes[i].type == "end")
						isEnd = true;
					else if(totalNodes[i].type == "sub")
						isSub = true;
				}
				if(!isStart || !(isEnd || isSub)){
					Interface.Event.trigger(Interface.EventMode.Alert,"流程无效，流程没有开始或结束的节点！")
					return false;
				}

				if(nextNode.type == "start" && nextNode.sourceConnections.length <= 0){
					Interface.Event.trigger(Interface.EventMode.Alert,"【"+nextNode.text + "】节点不是结束节点，但没有下一节点设置！流程没有结束！")
					return false;
				}else{
					var nextNodes = Interface.Editor.GetNodesNext(nextNode);
					if(nextNodes.length > 0){
						var NodesName = "";
						for(var i = 0; i < nextNodes.length; i++){
							if(NodesName != "")	NodesName += "、";
							NodesName += nextNodes[i].text;
						}
						Interface.Event.trigger(Interface.EventMode.Alert,"【" + NodesName + "】节点不是结束节点，但没有下一节点设置！流程没有结束！")
						return false;
					}else{
						return true;
					}
				}
			},
			GetNodesNext : function(obj) {
				var NextNodes = [];
				var Connections = obj.sourceConnections;
				for(var i = 0; i < Connections.length; i++){
					var Next = Connections[i].target;
					if(Next.sourceConnections.length <= 0){
						if(Next.type != "end" && Next.type != "sub")
						{
							if(NextNodes.length > 0){
								var isFind = false;
								for (var k = 0; k < NextNodes.length; k++)
								{
									if(NextNodes[k].text == Next.text){
										isFind = true;
										break;
									}
								}
								if(!isFind)
									NextNodes.push(Next);
							}else
								NextNodes.push(Next);
						}
						// else{
						// 	NextNodes.splice(0,NextNodes.length);
						// 	break;
						// }
					}else{
						var SubNodes = Interface.Editor.GetNodesNext(Next);
						if(SubNodes.length > 0)
						{
							if(NextNodes.length > 0)
							{
								for (var j = 0; j < SubNodes.length; j++)
								{
									var isFind = false;
									for (var k = 0; k < NextNodes.length; k++)
									{
										if(NextNodes[k].text == SubNodes[j].text){
											isFind = true;
											break;
										}
									}
									if(!isFind)
										NextNodes.push(SubNodes[j]);
								}
							}else{
								NextNodes = SubNodes;
							}
						}
						// else{
						// 	NextNodes.splice(0,NextNodes.length);
						// 	break;
						// }
					}
				}
				return NextNodes;
			},
			GetFlowNodesName : function() {
				var NodeNames = {};
				var editor = Interface.activeEditor;
				var model = editor.getGraphicalViewer().getContents().getModel();
				var totalNodes = model.getChildren();
				for(var i=0;i<totalNodes.length;i++)
				{
					var inTransitions = totalNodes[i].sourceConnections;
					var previousNodeName = [];
					if(null != inTransitions && inTransitions.length>0){
						for(var j=0;j<inTransitions.length;j++){
							previousNodeName.push(inTransitions[j].target.key)
						}
					}
					NodeNames[totalNodes[i].key] = {};
					if(previousNodeName.length > 0){
						NodeNames[totalNodes[i].key] = previousNodeName;
					}else{
						NodeNames[totalNodes[i].key] = "";
					}
				}
				return NodeNames;
			},
			SaveFlowInfo : function(){
				if(typeof Interface.activeEditor != "undefined")
				{
					return Interface.activeEditor.serial();
				}else{
					return "";
				}
			}
		};
	},
};