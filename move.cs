using UnityEngine;
using System.Collections;

public class move : MonoBehaviour {

	private Rigidbody2D myRigidbody;
	[SerializeField]
	private float moveSpeed;
	private bool faceingRight;
	private Animator myAnimator;
	private bool attack;
	private bool slide;

	[SerializeField]
	private Transform[] groundPoins;

	[SerializeField]
	private float groundRadius;

	[SerializeField]
	private LayerMask WhatIsGround;
	private bool isGrounded;
	[SerializeField]
	private bool airControl;
	private bool jump;
	private bool jumpAttack;

	[SerializeField]
	private float jumpForce;
	// Use this for initialization
	void Start () {
		faceingRight = true;
		myRigidbody = GetComponent<Rigidbody2D> ();
		myAnimator = GetComponent<Animator> ();
	}

	void Update(){
		HandleInput ();
	}
	// Update is called once per frame
	void FixedUpdate () {

		float horizontal = Input.GetAxis ("Horizontal");
		isGrounded = IsGrounded ();
		HandleMovement (horizontal);
		Flip (horizontal);
		HandleAttack ();
		HandleLayer ();
		ResetValues ();
	}
	private void HandleMovement(float horizontal){

		if (myRigidbody.velocity.y < 0) {
			myAnimator.SetBool ("land", true);
		}

		if(!myAnimator.GetBool("slide") && !this.myAnimator.GetCurrentAnimatorStateInfo(0).IsTag("Attack") && (isGrounded || airControl))
		{
			myRigidbody.velocity = new Vector2(horizontal *moveSpeed, myRigidbody.velocity.y);
		}
		if (isGrounded && jump) {
			isGrounded = false;
			myRigidbody.AddForce (new Vector2 (0, jumpForce));
			myAnimator.SetTrigger ("jump");
		}
		myAnimator.SetFloat ("speed",Mathf.Abs( horizontal));

		if (slide && !this.myAnimator.GetCurrentAnimatorStateInfo (0).IsName ("Slide")) {
			myAnimator.SetBool ("slide", true);
		} else if (!this.myAnimator.GetCurrentAnimatorStateInfo (0).IsName ("Slide")) {
			myAnimator.SetBool ("slide", false);
		}
			

	}

	private void Flip(float horizontal)
	{
		if (horizontal > 0 && !faceingRight || horizontal < 0 && faceingRight) {
			faceingRight = !faceingRight;
			Vector3 theScale = transform.localScale;
			theScale.x *= -1;
			transform.localScale = theScale;
		}
	}

	private void HandleAttack(){
		if (attack && isGrounded && !this.myAnimator.GetCurrentAnimatorStateInfo(0).IsTag("Attack")) {
			myAnimator.SetTrigger ("attack");
			myRigidbody.velocity = Vector2.zero;
		}
		if (jumpAttack && !isGrounded && !this.myAnimator.GetCurrentAnimatorStateInfo (1).IsName ("JumpAttack")) {
			myAnimator.SetBool ("attack", true);
		}
		if (!jumpAttack && !this.myAnimator.GetCurrentAnimatorStateInfo (1).IsName ("JumpAttack")) {
			myAnimator.SetBool ("attack", false);
		}
	}

	private void HandleInput(){
		if (Input.GetKeyDown (KeyCode.W) || Input.GetKeyDown (KeyCode.Space)) {
			jump = true;
		}
		if (Input.GetKeyDown (KeyCode.LeftShift)) {
			attack = true;
			jumpAttack = true;
		}
		if(Input.GetKeyDown(KeyCode.LeftControl)){
			slide = true;
		}
	}
	private void ResetValues(){
		attack = false;
		slide = false;
		jump = false;
		jumpAttack = false;
	}

	private bool IsGrounded(){
	
		if (myRigidbody.velocity.y <= 0) {
			foreach (Transform poin in groundPoins) {
				Collider2D[] colliders = Physics2D.OverlapCircleAll (poin.position, groundRadius, WhatIsGround);
				for (int i = 0; i < colliders.Length; i++) {
					if (colliders [i].gameObject != gameObject) {
						myAnimator.ResetTrigger ("jump");
						myAnimator.SetBool ("land", false);
						return true;
					}
				}
			}
		}
		return false;
	}
	private void HandleLayer(){
		if (!isGrounded) {
			myAnimator.SetLayerWeight (1, 1);
		} else {
			myAnimator.SetLayerWeight (1, 0);
		}
	}
}
