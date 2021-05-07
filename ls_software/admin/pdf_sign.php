
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Suggestion field using jQuery, PHP and MySQL - Learn infinity</title>
    
    <!-- Bootstrap Core Css -->
    <link href="css/bootstrap.css" rel="stylesheet" />

    <!-- Font Awesome Css -->
    <link href="css/font-awesome.min.css" rel="stylesheet" />

	<!-- Bootstrap Select Css -->
    <link href="css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/app_style.css" rel="stylesheet" />
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<style>
		
		#btnSaveSign {
			color: #fff;
			background: #f99a0b;
			padding: 5px;
			border: none;
			border-radius: 5px;
			font-size: 20px;
			margin-top: 10px;
		}
		#signArea{
			width:304px;
			margin: 15px auto;
		}
		.sign-container {
			width: 90%;
			margin: auto;
		}
		.sign-preview {
			width: 150px;
			height: 50px;
			border: solid 1px #CFCFCF;
			margin: 10px 5px;
		}
		.tag-ingo {
			font-family: cursive;
			font-size: 12px;
			text-align: left;
			font-style: oblique;
		}
		.center-text {
			text-align: center;
		}
	</style>
</head>
<body>
    <div class="all-content-wrapper">
		<!-- Top Bar -->
				<header>
			<style>
				.navbar-default {
					background: #fff;
				}
				ul.navbar-right li a:hover {
					background: #518d8a !important;
					color: #FFF !important;
				}
			</style>
			
		
			
		</header>
		<!-- #END# Top Bar -->
	
		<section class="container">
			<div class="form-group custom-input-space has-feedback">
				<div class="page-heading">
					<h3 class="post-title">jQuery Signature Pad & Canvas Image - Learn infinity</h3>
				</div>
				<div class="page-body clearfix">
					<div class="row">
						<div class="col-md-offset-1 col-md-10">
							<div class="panel panel-default">
								<div class="panel-heading">Digital Signature:</div>
								<div class="panel-body center-text">

								<div id="signArea" >
									<h2 class="tag-ingo">Put signature below,</h2>
									<div class="sig sigWrapper" style="height:auto;">
										<div class="typed"></div>
										<canvas class="sign-pad" id="sign-pad" width="300" height="100"></canvas>
									</div>
								</div>
								
								
								<button id="btnSaveSign">Save Signature</button>
		
								<div class="sign-container" style="display:none;">
																<img src="./doc_signs/01032de95dc2e9c35a75fd9668aafeba.png" class="sign-preview" />
																<img src="./doc_signs/012d6f06870f9c6b4c411478fa8321ba.png" class="sign-preview" />
																<img src="./doc_signs/03859ebe3f966b623b5bdd12691e91ef.png" class="sign-preview" />
																<img src="./doc_signs/03ebf03636f6dc7ccb2c0ac78c065f50.png" class="sign-preview" />
																<img src="./doc_signs/067342a4364bf1c4f478bd3c6161c06b.png" class="sign-preview" />
																<img src="./doc_signs/069fa9774db0cd734d0a8ecc197ea0aa.png" class="sign-preview" />
																<img src="./doc_signs/07a8e32013737ed56f92a540f7dac162.png" class="sign-preview" />
																<img src="./doc_signs/08332dbfdfb37886ffca8b39c7361ed8.png" class="sign-preview" />
																<img src="./doc_signs/08c78bba4ba02ed6315add6ef8026ffb.png" class="sign-preview" />
																<img src="./doc_signs/0b09d32a83565edffe3b5e0ed1f63cae.png" class="sign-preview" />
																<img src="./doc_signs/0b7824cd34c714d08778d6e429b828fd.png" class="sign-preview" />
																<img src="./doc_signs/0bd61f539e670aab4bafb232bcc3f676.png" class="sign-preview" />
																<img src="./doc_signs/0be656d8e49d0e3675df2b1e3995bd77.png" class="sign-preview" />
																<img src="./doc_signs/0d06b95cd7d701a663df4adbc2c9db13.png" class="sign-preview" />
																<img src="./doc_signs/0f2056a640939992a98193eee390f96a.png" class="sign-preview" />
																<img src="./doc_signs/11ecec94b10d4ce6e16521cda114c3a0.png" class="sign-preview" />
																<img src="./doc_signs/154f9a4c3d62fa1e75c6e4bd883f013a.png" class="sign-preview" />
																<img src="./doc_signs/15c44a02a8f20042bb11018ae1c82c6d.png" class="sign-preview" />
																<img src="./doc_signs/1673546ae29ceeb9e024b45c6292f3f2.png" class="sign-preview" />
																<img src="./doc_signs/16a76098d9b01042864e957c1b282997.png" class="sign-preview" />
																<img src="./doc_signs/1b52d78263b0ecf9e9ed7b971c1351ed.png" class="sign-preview" />
																<img src="./doc_signs/1c0fe9e93eef12b806df5f60502bab40.png" class="sign-preview" />
																<img src="./doc_signs/1cfcff8e163f990242d785ababc64dc8.png" class="sign-preview" />
																<img src="./doc_signs/1d24bd54c826343c69e557bbc14be06d.png" class="sign-preview" />
																<img src="./doc_signs/1d3907e339b316ea2ba53e4e91335946.png" class="sign-preview" />
																<img src="./doc_signs/1d3a95c125ae1167a6564a0c238ffbc1.png" class="sign-preview" />
																<img src="./doc_signs/24dfedf0b5b2e0ce9ae08f9ee0fcb017.png" class="sign-preview" />
																<img src="./doc_signs/26a8279cb433c22d7903ff7547b3106f.png" class="sign-preview" />
																<img src="./doc_signs/26b97856979a8c1112624d7a151b5d94.png" class="sign-preview" />
																<img src="./doc_signs/27206cdfed230027da7b9afa9d42700e.png" class="sign-preview" />
																<img src="./doc_signs/27b163467b95d922e5ebd03dc504af5d.png" class="sign-preview" />
																<img src="./doc_signs/28052b6ad36f2e2e29000c7d73ece954.png" class="sign-preview" />
																<img src="./doc_signs/296c4131867f950510b7224f6ac7733b.png" class="sign-preview" />
																<img src="./doc_signs/2abe9851756ce910f2bedfae7ca88a18.png" class="sign-preview" />
																<img src="./doc_signs/2aeb4d6e2ffb2aeb6156837c59e082aa.png" class="sign-preview" />
																<img src="./doc_signs/2afbf3dd2cee2f9b5aaf2fb0face50ac.png" class="sign-preview" />
																<img src="./doc_signs/2bd3ed0d6da3778066ec3c0a808b7c21.png" class="sign-preview" />
																<img src="./doc_signs/2d53f428dba5f57543d88fecc2b6e746.png" class="sign-preview" />
																<img src="./doc_signs/2d9cc302eccf98f7c5f789114b56286a.png" class="sign-preview" />
																<img src="./doc_signs/2f1f3572e1c918d5922478cd901371a8.png" class="sign-preview" />
																<img src="./doc_signs/3068496ab968b37a46adbf94f3dfdaa3.png" class="sign-preview" />
																<img src="./doc_signs/3163565d551f81a17f61a446c9d05957.png" class="sign-preview" />
																<img src="./doc_signs/3552e60e35b92db3f6de9985bb40a3f7.png" class="sign-preview" />
																<img src="./doc_signs/3646c2b0e99f5fbcee041beb9961b4d6.png" class="sign-preview" />
																<img src="./doc_signs/36ea2c58ff2aa65f97c3986f17862ea6.png" class="sign-preview" />
																<img src="./doc_signs/374c6c74908b0cbc6d8c8e48cb21e754.png" class="sign-preview" />
																<img src="./doc_signs/3a107fdfdba0fafafbbe99a93cc3899f.png" class="sign-preview" />
																<img src="./doc_signs/3a9cbf20d74434800ba113482ba8296f.png" class="sign-preview" />
																<img src="./doc_signs/3b597f18863f491bf03d35c700ca82f5.png" class="sign-preview" />
																<img src="./doc_signs/3bb43ad9438ad6295dd17961e133a065.png" class="sign-preview" />
																<img src="./doc_signs/3c9a13f5dc62e9ba5714664f162a9101.png" class="sign-preview" />
																<img src="./doc_signs/3cd868bc9fa86210d0485cd9983cc5c0.png" class="sign-preview" />
																<img src="./doc_signs/3d044f6ec24d2bb8be4a07a18a1c6705.png" class="sign-preview" />
																<img src="./doc_signs/3d230bd60636d4e1a844d53f618f1b37.png" class="sign-preview" />
																<img src="./doc_signs/404561c0eedf5ad557387e03f7cd21d7.png" class="sign-preview" />
																<img src="./doc_signs/413796e1511577827bff84244cbfae44.png" class="sign-preview" />
																<img src="./doc_signs/4380574b9d173edd397d25b1bcc9a250.png" class="sign-preview" />
																<img src="./doc_signs/43c19ede2d444163f405e85bca72fb50.png" class="sign-preview" />
																<img src="./doc_signs/44b8e0234f3467d28fcb8fb2dfdccdba.png" class="sign-preview" />
																<img src="./doc_signs/45604a8a69b379a0cdf689c357eb610b.png" class="sign-preview" />
																<img src="./doc_signs/469ca7df891417a48003e9328c583c91.png" class="sign-preview" />
																<img src="./doc_signs/490b751f37bf2341a7e2f2d9bf6437d7.png" class="sign-preview" />
																<img src="./doc_signs/495df4cc2b0754d5b0a15591625cfbe1.png" class="sign-preview" />
																<img src="./doc_signs/49abb110908a4f0b163de964eb7fba83.png" class="sign-preview" />
																<img src="./doc_signs/4a944957821e838cbef588d555c0dad4.png" class="sign-preview" />
																<img src="./doc_signs/4ba6b75d4444f1ff59e35dd67d8401d2.png" class="sign-preview" />
																<img src="./doc_signs/4bc92ef02a8a6cf2afefd65c588e4da0.png" class="sign-preview" />
																<img src="./doc_signs/4c10e88e64ef6524d88ba9fe919d2a67.png" class="sign-preview" />
																<img src="./doc_signs/4d4d4b3ffa47c08e0ac54eca706ce24d.png" class="sign-preview" />
																<img src="./doc_signs/4f047603a9aac19c6e8a4e57561f8c75.png" class="sign-preview" />
																<img src="./doc_signs/508fbeb51c40d3e26a33cfedf8637c89.png" class="sign-preview" />
																<img src="./doc_signs/53adaf060769db91bc3aca278deb60bf.png" class="sign-preview" />
																<img src="./doc_signs/54957eff6c84fcc284622a5c903a3432.png" class="sign-preview" />
																<img src="./doc_signs/55d64ee7e83c417d74629ccb3c74ddc9.png" class="sign-preview" />
																<img src="./doc_signs/5689ee9315192cad438a75e429ffb258.png" class="sign-preview" />
																<img src="./doc_signs/57d88babc7c6e5844da3e5f50daa8af8.png" class="sign-preview" />
																<img src="./doc_signs/5800f5a4de1983202e504f1178f5e813.png" class="sign-preview" />
																<img src="./doc_signs/592487695a26934e9f025f23b81a97d8.png" class="sign-preview" />
																<img src="./doc_signs/5926fff23864dc6efa835e7318f58232.png" class="sign-preview" />
																<img src="./doc_signs/5bf2b2636ec37001eb19b3b6494bca3b.png" class="sign-preview" />
																<img src="./doc_signs/6031932d8505ab12c8d1c28c1fa6ab79.png" class="sign-preview" />
																<img src="./doc_signs/606633efce6df43d300a5ae63b9193e0.png" class="sign-preview" />
																<img src="./doc_signs/60c6452c912846d5cf234f890285f725.png" class="sign-preview" />
																<img src="./doc_signs/63a2169b2dc8d005479e8f0aeb71631a.png" class="sign-preview" />
																<img src="./doc_signs/658a28fcc301b747e4b578fa12b6dd1f.png" class="sign-preview" />
																<img src="./doc_signs/6714806794f8aa8fa68d0284f15c384d.png" class="sign-preview" />
																<img src="./doc_signs/676505837cbcf1019518f1b2de62882c.png" class="sign-preview" />
																<img src="./doc_signs/68b7c2fbb8d7a31f609725c3b7e791ce.png" class="sign-preview" />
																<img src="./doc_signs/6921f6b5551c1ee34fef3cf41d53ab9a.png" class="sign-preview" />
																<img src="./doc_signs/6d2d7a3961aa5f84fb111312f5a6958c.png" class="sign-preview" />
																<img src="./doc_signs/6e9350e5a6323ef8806acf7536edbb6c.png" class="sign-preview" />
																<img src="./doc_signs/72109542c1d432ae396ce6fc76899e09.png" class="sign-preview" />
																<img src="./doc_signs/75d641fd65ec30aadf95d3c24133ef1f.png" class="sign-preview" />
																<img src="./doc_signs/76687806402131731a4bb7f09920f5ac.png" class="sign-preview" />
																<img src="./doc_signs/7742704d6ea94d04bb2a376db10777ff.png" class="sign-preview" />
																<img src="./doc_signs/7c76814e8cff30ed84b168ce130391d1.png" class="sign-preview" />
																<img src="./doc_signs/7ce8e8484bd52907e5d7c1a0a717476f.png" class="sign-preview" />
																<img src="./doc_signs/7d4feca07b94fbb0f89edd6707d0a6a8.png" class="sign-preview" />
																<img src="./doc_signs/7f82984559654c50c754e266452bb335.png" class="sign-preview" />
																<img src="./doc_signs/800e404ba7e315838e7dffd47728f4d0.png" class="sign-preview" />
																<img src="./doc_signs/82fcaa875b38b993ab32216ef693dce4.png" class="sign-preview" />
																<img src="./doc_signs/8342e897eff0a1f865de7f2afe2e39e3.png" class="sign-preview" />
																<img src="./doc_signs/845feefb0237dc38ef12748c84a514af.png" class="sign-preview" />
																<img src="./doc_signs/846038e8291cb69102b9cf3f79230b8e.png" class="sign-preview" />
																<img src="./doc_signs/867e29809737cfca09cac037dc2d24fd.png" class="sign-preview" />
																<img src="./doc_signs/88220b000fb1703d9968e40ceca712ac.png" class="sign-preview" />
																<img src="./doc_signs/88baf99ba29b6b7c89213ad22bfa6ac8.png" class="sign-preview" />
																<img src="./doc_signs/8a1389b97dc3c0102a7e4519c99007eb.png" class="sign-preview" />
																<img src="./doc_signs/8b3786a9cb1b33a5be07c6ed77dcf8be.png" class="sign-preview" />
																<img src="./doc_signs/8bb2105d551b621b6bf63d28d465f6a7.png" class="sign-preview" />
																<img src="./doc_signs/8c5aa5c896cb0341951d65d1641d150a.png" class="sign-preview" />
																<img src="./doc_signs/8eaf07a8b07f20011fa83bbca1c85797.png" class="sign-preview" />
																<img src="./doc_signs/90bf193ae16e90ce6a3a6dee056e502f.png" class="sign-preview" />
																<img src="./doc_signs/91473a7a0f6227b6d01553092a07d7e2.png" class="sign-preview" />
																<img src="./doc_signs/929363bde9dea1e396309ca527482d1c.png" class="sign-preview" />
																<img src="./doc_signs/942e780491ec198b471b0f47443cc1a7.png" class="sign-preview" />
																<img src="./doc_signs/951c35950f6a3b6ec400cfa793e48de7.png" class="sign-preview" />
																<img src="./doc_signs/95b29df6e639f422265e54cc7f13dffa.png" class="sign-preview" />
																<img src="./doc_signs/99fa9169a8d820012aaa0f2461f8f5b6.png" class="sign-preview" />
																<img src="./doc_signs/9ec94d6ec0d857deaac6a9808f284883.png" class="sign-preview" />
																<img src="./doc_signs/9ef90a2d5f06d0abc3317a4c64e9d613.png" class="sign-preview" />
																<img src="./doc_signs/9eff842330c05ef07f3fb75f231afbf4.png" class="sign-preview" />
																<img src="./doc_signs/a06e07431504c113ebd9741454f43b8a.png" class="sign-preview" />
																<img src="./doc_signs/a0e01952e0c35faa78f84757374dbf7b.png" class="sign-preview" />
																<img src="./doc_signs/a1059424fb4cda76ff76adcb1b03406a.png" class="sign-preview" />
																<img src="./doc_signs/a1fdbc0ff2819a218e4d3e54f5f6fdb3.png" class="sign-preview" />
																<img src="./doc_signs/a24046e275a191f2c49ab6c1f2dc36d7.png" class="sign-preview" />
																<img src="./doc_signs/a5d5bbceea510cb9bcd1f83c8daca1e7.png" class="sign-preview" />
																<img src="./doc_signs/a779259f404769df9e1b685bedbd7994.png" class="sign-preview" />
																<img src="./doc_signs/aba815e63a9e837432120e14de5fa7ac.png" class="sign-preview" />
																<img src="./doc_signs/abca80feadc638831fa5e151417ee678.png" class="sign-preview" />
																<img src="./doc_signs/ad986da8986695daf7bab7f341b4799c.png" class="sign-preview" />
																<img src="./doc_signs/aeb748f859bdc6afa5cb2fa2a1824e27.png" class="sign-preview" />
																<img src="./doc_signs/af4ad7da58916776fc9af0afc77f7866.png" class="sign-preview" />
																<img src="./doc_signs/b1bdeacc6dcc0bf5a2b25a2c8aa73d59.png" class="sign-preview" />
																<img src="./doc_signs/b3b7b957a3e285d409a1605df70d6343.png" class="sign-preview" />
																<img src="./doc_signs/b414f0d8ecacc6023d11c9f600577e64.png" class="sign-preview" />
																<img src="./doc_signs/b59aec4b8be45eb6fd142d3312a55e9a.png" class="sign-preview" />
																<img src="./doc_signs/b5b3301ca388433feaa96a7a32cd5ecc.png" class="sign-preview" />
																<img src="./doc_signs/b6e632d9fbdce8d12731a106aa582b9d.png" class="sign-preview" />
																<img src="./doc_signs/b818ef47fb45bdf8d761ba9c47f28e89.png" class="sign-preview" />
																<img src="./doc_signs/b972fa61b734b42d69d9ce30c0a85d77.png" class="sign-preview" />
																<img src="./doc_signs/b9f9444e263eb8c767a5e4a96efaa5ff.png" class="sign-preview" />
																<img src="./doc_signs/bb392908a3291c6188e4a8d59d63edc0.png" class="sign-preview" />
																<img src="./doc_signs/bbffdeb05a68cd5a4c56d3b125c01135.png" class="sign-preview" />
																<img src="./doc_signs/bd8b80265e88bdf9ec66e99c234e70f8.png" class="sign-preview" />
																<img src="./doc_signs/c2776c041004fcb858b0c31d23653b50.png" class="sign-preview" />
																<img src="./doc_signs/c3afcde3037590a56ced450ea62bdc34.png" class="sign-preview" />
																<img src="./doc_signs/c5f8ed96213a5afd4e4ba1be524e5473.png" class="sign-preview" />
																<img src="./doc_signs/c6e9fd87ac4e16c8d3a54111c7a2d5c4.png" class="sign-preview" />
																<img src="./doc_signs/c7f055dfa8a7e1ddb6e668a59879d86e.png" class="sign-preview" />
																<img src="./doc_signs/c8eeecef9e8723c36b7bab1456e794df.png" class="sign-preview" />
																<img src="./doc_signs/cba54ddf4a4dbb1aded1090809118d7e.png" class="sign-preview" />
																<img src="./doc_signs/ccee24ca7330db875a41e88ee682d320.png" class="sign-preview" />
																<img src="./doc_signs/cf62b4074938ba60ed756f995a57d0c9.png" class="sign-preview" />
																<img src="./doc_signs/d0e4eb5300b4696d53a5623ed8a6d847.png" class="sign-preview" />
																<img src="./doc_signs/d1dd53d36e9d34340d5470f467c8c581.png" class="sign-preview" />
																<img src="./doc_signs/d3adeadc176d738986b1152037398f84.png" class="sign-preview" />
																<img src="./doc_signs/d8f8b4ad9a0d69c35e144d91906c3cd7.png" class="sign-preview" />
																<img src="./doc_signs/d9c03ccea3731d22d8baa9faf76f358c.png" class="sign-preview" />
																<img src="./doc_signs/d9eab563ef224b9fd4ea11bce75b006d.png" class="sign-preview" />
																<img src="./doc_signs/db5983f605a4837ec99be76dd46a4de3.png" class="sign-preview" />
																<img src="./doc_signs/db5afd6116309ee2dda86c1e40151655.png" class="sign-preview" />
																<img src="./doc_signs/dba381ee46162bbaa25f9911bab25777.png" class="sign-preview" />
																<img src="./doc_signs/dc042e7fe575ba04dd5f4c5631717750.png" class="sign-preview" />
																<img src="./doc_signs/e204d9b4961240428843a2de8434be7d.png" class="sign-preview" />
																<img src="./doc_signs/e2f3bdf62245f4ef6d04b92139fe435f.png" class="sign-preview" />
																<img src="./doc_signs/e35c7ffb8521089158ea89cb21a59d11.png" class="sign-preview" />
																<img src="./doc_signs/e4d53b56ff7348297b4aff724beb5df8.png" class="sign-preview" />
																<img src="./doc_signs/e5f073f27aeb38247e81495bb0c6dad5.png" class="sign-preview" />
																<img src="./doc_signs/eaf24e939927654590215a421fdb956a.png" class="sign-preview" />
																<img src="./doc_signs/ebfa2c860bd03d0643bac6566dbfa602.png" class="sign-preview" />
																<img src="./doc_signs/ed39d0f18ce8b3335eb738cfb8ab0c18.png" class="sign-preview" />
																<img src="./doc_signs/f0534d3567af073b745df55fb37f1365.png" class="sign-preview" />
																<img src="./doc_signs/f05d48ecf6022c7d3b0775d385a6659e.png" class="sign-preview" />
																<img src="./doc_signs/f08cc60c06519b39d24b164e6b7efdc3.png" class="sign-preview" />
																<img src="./doc_signs/f2250a9f51a393bb8c17dd1a2a8a8c91.png" class="sign-preview" />
																<img src="./doc_signs/f3894549d343626b498d0465d915db57.png" class="sign-preview" />
																<img src="./doc_signs/f4722e1f2f51f93eae19b631af0daf6f.png" class="sign-preview" />
																<img src="./doc_signs/f4caf66ee6d302808acf692efc047dc7.png" class="sign-preview" />
																<img src="./doc_signs/f7664564906e6f1876f1ad0fa5be3129.png" class="sign-preview" />
																<img src="./doc_signs/f8bdd5e29d022793b87dd2295fcfe4cf.png" class="sign-preview" />
																<img src="./doc_signs/f90099e055bc15c5bd576e848f8bb6c5.png" class="sign-preview" />
																<img src="./doc_signs/f9b9394a6ec416c1e3871de0c306eda4.png" class="sign-preview" />
																<img src="./doc_signs/fc30dc61554dad25e58aefea01700319.png" class="sign-preview" />
																<img src="./doc_signs/fc3d1b0f8546db930551f1d1f2f0471d.png" class="sign-preview" />
																<img src="./doc_signs/fca12fcb696821a2b3ea1885c7cbf9bf.png" class="sign-preview" />
																<img src="./doc_signs/ff6d3b32dcb3d7a97b00bc7b43334589.png" class="sign-preview" />
																<img src="./doc_signs/ffe83653b6e65e7564738974624377f5.png" class="sign-preview" />
																</div>
									

								</div>
							</div>
						</div>


					</div>
				</div>
			</div>
		</section>
    </div>
	
	<!-- Jquery Core Js -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Bootstrap Select Js -->
    <script src="js/bootstrap-select.js"></script>

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<link href="./css/jquery.signaturepad.css" rel="stylesheet">
	<script src="./js/numeric-1.2.6.min.js"></script> 
	<script src="./js/bezier.js"></script>
	<script src="./js/jquery.signaturepad.js"></script> 
	
	<script type='text/javascript' src="https://github.com/niklasvh/html2canvas/releases/download/0.4.1/html2canvas.js"></script>
	<script src="./js/json2.min.js"></script>
	
	<script>

	$(document).ready(function(e){

		$(document).ready(function() {
			$('#signArea').signaturePad({drawOnly:true, drawBezierCurves:true, lineTop:90});
		});
		
		$("#btnSaveSign").click(function(e){
			html2canvas([document.getElementById('sign-pad')], {
				onrendered: function (canvas) {
					var canvas_img_data = canvas.toDataURL('image/png');
					var img_data = canvas_img_data.replace(/^data:image\/(png|jpg);base64,/, "");
					//ajax call to save image inside folder
					$.ajax({
						url: 'save_sign.php',
						data: { img_data:img_data },
						type: 'post',
						dataType: 'json',
						success: function (response) {
						   window.location.reload();
						}
					});
				}
			});
		});

	});
	</script>
</body>
</html>
