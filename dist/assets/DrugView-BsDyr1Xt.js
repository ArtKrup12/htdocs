import{H as P}from"./HeadText-Bz_rNvnu.js";import{f as w,g as D,_ as T,I as U,s as M,h as d,d as S,c as n,b as r,e as x,F as k,i as C,a as j,w as q,j as y,v as A,k as h,l as B,m as E,o as l,t as b,r as v}from"./index-Dry03Yow.js";import{l as H}from"./index-Cok8esS-.js";const z=w("addData",{state:()=>({}),getters:{},actions:{async addDrug(s,e,g,o,c,u){try{const a=new FormData;return a.append("drugId",s),a.append("lotNo",e),a.append("quantity",g),a.append("dateExp",c),a.append("respPerson",o),a.append("img",u),(await D.post("undefined/list/addList",a,{headers:{"Content-Type":"multipart/form-data"}})).data.status===200}catch(a){console.error(a)}}}}),G=w("getDrug",{state:()=>({}),getters:{},actions:{async getDrug(){try{return(await D.get("undefined/drug/getDrug",{},{headers:{"Content-Type":"application/json"}})).data}catch(s){console.error(s)}}}}),O=w("getList",{state:()=>({}),getters:{},actions:{async getList(){try{const s=(await D.post("undefined/list/getList",{},{headers:{"Content-Type":"application/json"}})).data;return console.log(s),s}catch(s){console.error(s)}}}}),R={components:{HeadText:P,Icon:U,sideMenu:M},setup(){const s=d(),e=d(),g=d(),o=d(),c=d(),u=d(null),a=d(null),f=d(!1),m=d([{text:"One",value:"A"},{text:"Two",value:"B"},{text:"Three",value:"C"}]),t=d([]),F=z(),L=G(),V=O(),I=async()=>{await F.addDrug(s.value,e.value,g.value,o.value,c.value,u.value)?(console.log("add"),location.reload()):console.log("no add")},_=async()=>{try{const i=await L.getDrug(),p=await V.getList();t.value=p,m.value=i.map(N=>({text:N.name,value:N._id}))}catch(i){console.error("Error fetching data from API:",i)}};return S(()=>{H(),_()}),console.log(t),{lists:t,drugName:s,lotNo:e,numDrug:g,respPerson:o,previewUrl:a,uploadSuccess:f,options:m,expDate:c,onFileChange:i=>{const p=i.target.files[0];p&&(u.value=p,a.value=URL.createObjectURL(p))},addDrug:I,fetchDataFromAPI:_}}},X={class:"overflow-y-auto",style:{height:"80vh"}},J={href:"#",class:"block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"},K={class:"mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"},Q={class:"flex flex-col"},W={class:"font-normal text-gray-700 dark:text-gray-400"},Y={class:"font-normal text-gray-700 dark:text-gray-400"},Z={class:"font-normal text-gray-700 dark:text-gray-400"},$={key:1,class:"mb-2 mt-2"},ee={class:"fixed bottom-20 right-5 z-50"},re={type:"button","data-modal-target":"crud-modal","data-modal-toggle":"crud-modal",class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"},te={id:"crud-modal",tabindex:"-1","aria-hidden":"true",class:"hidden duration-1000 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"},oe={class:"relative w-full max-w-7xl max-h-full"},ae={class:"relative bg-white rounded-lg shadow dark:bg-gray-700"},se={class:"grid gap-4 mb-4 grid-cols-2"},de={class:"col-span-2"},ne=["value"],le={class:"col-span-2 sm:col-span-1"},ie={class:"col-span-2 sm:col-span-1"},ge={class:"col-span-2 sm:col-span-1"},ce={class:"col-span-2"},ue={class:"col-span-2"},me={class:"col-span-2"},pe={key:0},ye=["src"],be={type:"submit",class:"text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"};function fe(s,e,g,o,c,u){const a=v("sideMenu"),f=v("HeadText"),m=v("Icon");return l(),n(k,null,[r("div",null,[x(a),x(f),r("div",X,[o.lists.length>0?(l(!0),n(k,{key:0},C(o.lists,t=>(l(),n("div",{key:t,class:"mb-2 mt-2"},[r("a",J,[r("h5",K,b(t.drugId.name),1),r("div",Q,[r("span",W,"lot no : "+b(t.lotNo),1),r("span",Y,"exp : "+b(t.dateExp)+" เหลืออีก * วัน หมดอายุ",1),r("span",Z,"จำนวน : "+b(t.quantity),1)])])]))),128)):(l(),n("div",$,e[7]||(e[7]=[r("span",{class:"block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"},[r("h5",{class:"mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"},"ไม่มีข้อมูล")],-1)])))])]),r("div",ee,[r("button",re,[x(m,{icon:"charm:plus",width:"28",height:"28",style:{color:"white"}}),e[8]||(e[8]=r("span",{class:"sr-only"},"Icon description",-1))])]),r("div",te,[r("div",oe,[r("div",ae,[e[17]||(e[17]=j('<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"><h3 class="text-lg font-semibold text-gray-900 dark:text-white"> เพิ่มยาความเสี่ยงสูง </h3><button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal"><svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path></svg><span class="sr-only">Close modal</span></button></div>',1)),r("form",{onSubmit:e[6]||(e[6]=q((...t)=>o.addDrug&&o.addDrug(...t),["prevent"])),method:"post",class:"p-4 md:p-5"},[r("div",se,[r("div",de,[e[9]||(e[9]=r("label",{for:"category",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"ชื่อยา",-1)),y(r("select",{id:"drugName","onUpdate:modelValue":e[0]||(e[0]=t=>o.drugName=t),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"},[(l(!0),n(k,null,C(o.options,t=>(l(),n("option",{value:t.value},b(t.text),9,ne))),256))],512),[[A,o.drugName]])]),r("div",le,[e[10]||(e[10]=r("label",{for:"price",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"Lot No.",-1)),y(r("input",{type:"text",name:"lotNo",id:"lotNo","onUpdate:modelValue":e[1]||(e[1]=t=>o.lotNo=t),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500",placeholder:"EX000",required:""},null,512),[[h,o.lotNo]])]),r("div",ie,[e[11]||(e[11]=r("label",{for:"price",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"วันหมดอายุ",-1)),y(r("input",{type:"text",name:"expDate",id:"expDate","onUpdate:modelValue":e[2]||(e[2]=t=>o.expDate=t),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500",placeholder:"dd-mm-yyyy",required:""},null,512),[[h,o.expDate]])]),r("div",ge,[e[12]||(e[12]=r("label",{for:"price",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"จำนวน",-1)),y(r("input",{type:"number",name:"numDrug",id:"numDrug","onUpdate:modelValue":e[3]||(e[3]=t=>o.numDrug=t),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500",placeholder:"1",required:""},null,512),[[h,o.numDrug]])]),r("div",ce,[e[13]||(e[13]=r("label",{for:"price",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"ผู้รับผิดชอบ",-1)),y(r("input",{type:"text",name:"respPerson",id:"respPerson","onUpdate:modelValue":e[4]||(e[4]=t=>o.respPerson=t),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500",placeholder:"",required:""},null,512),[[h,o.respPerson]])]),r("div",ue,[e[14]||(e[14]=r("label",{class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white",for:"file_input"},"เพิ่มรูปภาพ",-1)),r("input",{class:"block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400",id:"imageFile",type:"file",accept:"image/*;capture=camera",onChange:e[5]||(e[5]=(...t)=>o.onFileChange&&o.onFileChange(...t))},null,32)]),r("div",me,[o.previewUrl?(l(),n("div",pe,[e[15]||(e[15]=r("h4",null,"Preview:",-1)),r("img",{src:o.previewUrl,alt:"Image Preview",style:{"max-width":"80%","margin-top":"10px"}},null,8,ye)])):B("",!0)])]),r("button",be,[x(m,{icon:"ic:round-add",width:"24",height:"24",style:{color:"white"}}),e[16]||(e[16]=E(" เพิ่มยา "))])],32)])])])],64)}const we=T(R,[["render",fe]]);export{we as default};
